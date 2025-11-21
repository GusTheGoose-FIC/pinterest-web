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
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


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
                ->orderByDesc('created_at')
                ->limit(60)
                ->get();

            // Adaptar al formato esperado por la vista ($images con 'url' y 'title')
            $images = $pins->map(function ($pin) {
                return [
                    'url' => $pin->image_url, // Accesor traerá de Mongo si está null
                    'title' => $pin->title ?? 'Imagen',
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

        return view('InicioLogueado', ['images' => $images]);
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
}
