<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Pin;
use App\Models\PinPostgres;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class inicioController extends Controller
{
    public function inicio()
    {
        return view('inicio');
    }

    public function Información()
    {
        return view('Información');
    }
     public function empresa()
    {
        return view('empresa');
    }
     public function Create()
    {
        return view('Create');
    }
     public function News()
    {
        return view('News');
    }
      public function Login()
    {
        return view('Login');
    }
    public function Condiciones()
    {
        return view('Condiciones');
    }
    public function PoliticasPrivacidad()
    {
        return view('PoliticasPrivacidad');
    }
    public function Comunidad()
    {
        return view('Comunidad');
    }
    public function propiedadIntelectual()
    {
        return view('propiedadIntelectual');
    }
    public function marcaComercial()
    {
        return view('marcaComercial');
    }
    public function Transparencia()
    {
        return view('transparencia');
    }
    public function Mas()
    {
        return view('Mas');
    }
    public function Ayuda()
    {
        return view('Ayuda');
    }
    public function AvisosnoUsuario()
    {
        return view('AvisosnoUsuario');
    }
    public function Liderazgo()
    {
        return view('Liderazgo');
    }
    public function buscaIdea()
    {
        return view('inicio.buscaIdea');
    }

    public function guardaIdeas()
    {
        return view('inicio.guardaIdeas');
    }

    public function crealo()
    {
        return view('inicio.crealo');
    }

    public function inicioLogueado()
    {
        // Preferir Postgres como fuente principal y "jalar" la imagen desde Mongo usando mongo_id
        try {
            $pins = PinPostgres::query()
                ->with('user.userProfile')
                ->orderByDesc('created_at')
                ->limit(60)
                ->get();

            // Adaptar al formato esperado por la vista ($images con 'url', 'title', 'id', etc.)
            $images = $pins->map(function ($pin) {
                return [
                    'id' => $pin->id,
                    'url' => $pin->image_url, // Accesor traerá de Mongo si está null
                    'image_url' => $pin->image_url,
                    'title' => $pin->title ?? 'Imagen',
                    'description' => $pin->description ?? '',
                    'allow_comments' => $pin->allow_comments,
                    'user_id' => $pin->user_id,
                    'user_name' => $pin->user && $pin->user->userProfile ? $pin->user->userProfile->username : ($pin->user->email ?? 'Usuario'),
                    'created_at' => $pin->created_at->diffForHumans(),
                ];
            });
        } catch (\Throwable $e) {
            // Fallback: si falla Postgres, intentar desde Mongo colección images
            try {
                $images = Image::query()
                    ->orderByDesc('created_at')
                    ->limit(60)
                    ->get();
            } catch (\Throwable $e) {
                $images = collect();
            }
        }

        // Obtener los pins del usuario autenticado
        $userPins = [];
        if (Auth::check()) {
            try {
                $userPinsQuery = PinPostgres::query()
                    ->where('user_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->get();

                $userPins = $userPinsQuery->map(function ($pin) {
                    return [
                        'id' => $pin->id,
                        'title' => $pin->title ?? 'Sin título',
                        'description' => $pin->description ?? '',
                        'image_url' => $pin->image_url,
                        'created_at' => $pin->created_at->diffForHumans(),
                        'allow_comments' => $pin->allow_comments,
                    ];
                })->toArray();
            } catch (\Throwable $e) {
                $userPins = [];
            }
        }

        return view('InicioLogueado', ['images' => $images, 'userPins' => $userPins]);
    }
    public function creacionPines()
    {
        return view('creacionPines');
    }

    public function storePin(Request $request)
    {
        // Validar datos del formulario
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:20480', // max 20MB
            'link' => 'nullable|url',
            'board' => 'nullable|string',
            'tags' => 'nullable|array',
            'products' => 'nullable|array',
            'allow_comments' => 'nullable|boolean',
            'show_similar' => 'nullable|boolean',
            'alt_text' => 'nullable|string',
        ]);

        // Subir la imagen a Cloudinary o storage local
        try {
            if ($request->hasFile('image')) {
                // Intentar subir a Cloudinary primero
                $uploadedFileUrl = Cloudinary::upload($request->file('image')->getRealPath(), [
                    'folder' => 'pins'
                ])->getSecurePath();
            } else {
                return back()->withErrors(['image' => 'La imagen es requerida']);
            }
        } catch (\Exception $e) {
            // Si falla Cloudinary, usar storage local
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('pins', 'public');
                $uploadedFileUrl = asset('storage/' . $imagePath);
            } else {
                return back()->withErrors(['image' => 'Error al subir la imagen']);
            }
        }

        // Crear el pin en MongoDB
        $pinMongo = Pin::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'] ?? '',
            'description' => $validated['description'] ?? '',
            'image_url' => $uploadedFileUrl,
            'link' => $validated['link'] ?? null,
            'board' => $validated['board'] ?? null,
            'tags' => $validated['tags'] ?? [],
            'products' => $validated['products'] ?? [],
            'allow_comments' => $request->has('allow_comments'),
            'show_similar' => $request->has('show_similar'),
            'alt_text' => $validated['alt_text'] ?? '',
        ]);

        // Crear el pin en PostgreSQL
        $pinPostgres = PinPostgres::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'] ?? '',
            'description' => $validated['description'] ?? '',
            // Guardamos null para que Postgres "jale" la URL desde Mongo mediante el accessor
            'image_url' => null,
            'link' => $validated['link'] ?? null,
            'board' => $validated['board'] ?? null,
            'allow_comments' => $request->has('allow_comments'),
            'show_similar' => $request->has('show_similar'),
            'alt_text' => $validated['alt_text'] ?? '',
            'mongo_id' => $pinMongo->id ?? null, // Guardar referencia al documento de MongoDB
        ]);

        // También crear registro en la colección images para el feed
        Image::create([
            'url' => $uploadedFileUrl,
            'title' => $validated['title'] ?? '',
            'user_id' => Auth::id(),
            'tags' => $validated['tags'] ?? [],
        ]);

        return redirect()->route('inicioLogueado')->with('success', 'Pin publicado exitosamente');
    }

    public function creacionPinesMultiple()
    {
        return view('creacionPinesMultiple');
    }

    public function storeMultiplePins(Request $request)
    {
        // Obtener los datos JSON
        $inputPins = $request->json('pins', []);

        if (empty($inputPins)) {
            return response()->json(['success' => false, 'message' => 'No hay pines para publicar']);
        }

        try {
            $createdPins = 0;
            $errors = [];

            foreach ($inputPins as $index => $pinData) {
                // Procesar imagen base64
                $imageData = $pinData['image_data'] ?? null;
                $uploadedFileUrl = null;

                if (!$imageData) {
                    $errors[] = "Pin " . ($index + 1) . ": No hay datos de imagen";
                    continue;
                }

                if (strpos($imageData, 'data:image') !== 0) {
                    $errors[] = "Pin " . ($index + 1) . ": Formato de imagen inválido";
                    continue;
                }

                try {
                    // Procesar imagen base64 de Cloudinary
                    $uploadedFileUrl = Cloudinary::upload($imageData, [
                        'folder' => 'pinterest/pins',
                        'resource_type' => 'auto',
                    ])->getSecurePath();
                    \Log::info('Cloudinary upload successful for pin ' . ($index + 1));
                } catch (\Exception $e) {
                    \Log::error('Cloudinary failed: ' . $e->getMessage());
                    
                    // Si falla Cloudinary, usar almacenamiento local en public/uploads
                    try {
                        // Crear directorio si no existe
                        $uploadsPath = public_path('uploads/pins');
                        if (!is_dir($uploadsPath)) {
                            mkdir($uploadsPath, 0777, true);
                        }

                        // Decodificar base64
                        $cleanBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $imageData);
                        $imageContent = base64_decode($cleanBase64);
                        
                        if (!$imageContent) {
                            $errors[] = "Pin " . ($index + 1) . ": Error al decodificar base64";
                            continue;
                        }

                        $filename = 'pin-' . time() . '-' . uniqid() . '.jpg';
                        $filepath = $uploadsPath . '/' . $filename;
                        
                        // Guardar archivo
                        $bytes = file_put_contents($filepath, $imageContent);
                        
                        if ($bytes === false) {
                            $errors[] = "Pin " . ($index + 1) . ": Error al escribir archivo";
                            \Log::error('Failed to write file: ' . $filepath);
                            continue;
                        }
                        
                        chmod($filepath, 0644);
                        $uploadedFileUrl = asset('uploads/pins/' . $filename);
                        \Log::info('Local file upload successful: ' . $uploadedFileUrl);
                    } catch (\Exception $storageException) {
                        \Log::error('Storage error for pin ' . ($index + 1) . ': ' . $storageException->getMessage());
                        $errors[] = "Pin " . ($index + 1) . ": " . $storageException->getMessage();
                        continue;
                    }
                }

                if (!$uploadedFileUrl) {
                    $errors[] = "Pin " . ($index + 1) . ": No se pudo obtener URL de imagen";
                    continue;
                }

                // Crear el pin en MongoDB
                $pinMongo = Pin::create([
                    'user_id' => Auth::id(),
                    'title' => $pinData['title'] ?? '',
                    'description' => $pinData['description'] ?? '',
                    'image_url' => $uploadedFileUrl,
                    'link' => null,
                    'board' => $pinData['board'] ?? null,
                    'tags' => [],
                    'products' => [],
                    'allow_comments' => isset($pinData['allow_comments']) && $pinData['allow_comments'],
                    'show_similar' => false,
                    'alt_text' => '',
                ]);

                // Crear el pin en PostgreSQL
                $pinPostgres = PinPostgres::create([
                    'user_id' => Auth::id(),
                    'title' => $pinData['title'] ?? '',
                    'description' => $pinData['description'] ?? '',
                    'image_url' => null,
                    'link' => null,
                    'board' => $pinData['board'] ?? null,
                    'allow_comments' => isset($pinData['allow_comments']) && $pinData['allow_comments'],
                    'show_similar' => false,
                    'alt_text' => '',
                    'mongo_id' => $pinMongo->id ?? null,
                ]);

                // Crear registro en la colección images para el feed
                Image::create([
                    'url' => $uploadedFileUrl,
                    'title' => $pinData['title'] ?? '',
                    'user_id' => Auth::id(),
                    'tags' => [],
                ]);

                $createdPins++;
            }

            if ($createdPins === 0) {
                $errorMsg = !empty($errors) ? implode('; ', $errors) : 'No se pudieron procesar los pines';
                return response()->json(['success' => false, 'message' => $errorMsg]);
            }

            $message = $createdPins === 1 ? '1 pin publicado exitosamente' : $createdPins . ' pines publicados exitosamente';
            if (!empty($errors)) {
                $message .= ' (' . count($errors) . ' con errores: ' . implode('; ', $errors) . ')';
            }
            return response()->json(['success' => true, 'message' => $message]);

        } catch (\Exception $e) {
            \Log::error('storeMultiplePins error: ' . $e->getMessage() . ' ' . $e->getTraceAsString());
            return response()->json(['success' => false, 'message' => 'Error al publicar los pines: ' . $e->getMessage()]);
        }
    }
}
