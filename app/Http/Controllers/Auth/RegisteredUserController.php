<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function registro(): View
    {
        return view('registro');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', Rules\Password::defaults()],
            'date'=>['required']
        ]);

        $user = User::create([
            
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'date'=> $request->date 
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('inicio', absolute: false));

        
    }

    public function Userprofile(){
        
        return $this->hasOne(UserProfile::class);
    }
}
