<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'user:create-admin {email} {password}';

    /**
     * The console command description.
     */
    protected $description = 'Create an admin user with email and password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Verificar si ya existe
        if (User::where('email', $email)->exists()) {
            $this->error('El usuario con email ' . $email . ' ya existe!');
            return 1;
        }

        try {
            // Crear usuario
            $user = User::create([
                'email' => $email,
                'password' => Hash::make($password),
                'date' => now()->format('Y-m-d'),
            ]);

            // Crear perfil
            UserProfile::create([
                'user_id' => $user->id,
                'username' => 'Admin',
                'bio' => 'Administrador del sistema Pinterest Clone',
            ]);

            $this->info('✅ Usuario administrador creado exitosamente!');
            $this->info('Email: ' . $email);
            $this->info('Contraseña: ' . $password);
            $this->info('Ahora puedes iniciar sesión y acceder al panel de admin.');

            return 0;

        } catch (\Exception $e) {
            $this->error('Error al crear usuario: ' . $e->getMessage());
            return 1;
        }
    }
}