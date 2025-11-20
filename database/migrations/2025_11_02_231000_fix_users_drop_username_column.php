<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Si existe la columna username en users, la hacemos NULLABLE o la eliminamos
        if (Schema::hasColumn('users', 'username')) {
            try {
                // Primero quitar NOT NULL para evitar bloqueos a inserts en caliente
                DB::statement('ALTER TABLE users ALTER COLUMN username DROP NOT NULL');
            } catch (\Throwable $e) {
                // Ignorar si falla; puede que no tenga NOT NULL
            }

            try {
                // Luego eliminarla porque ahora el username vive en user_profiles
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('username');
                });
            } catch (\Throwable $e) {
                // Si no se puede eliminar por alguna razón, al menos quedó nullable
            }
        }

        // De paso, si existe una columna bio en users, la eliminamos
        if (Schema::hasColumn('users', 'bio')) {
            try {
                DB::statement('ALTER TABLE users ALTER COLUMN bio DROP NOT NULL');
            } catch (\Throwable $e) {}

            try {
                Schema::table('users', function (Blueprint $table) {
                    $table->dropColumn('bio');
                });
            } catch (\Throwable $e) {}
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Re-crear columnas de manera opcional y nullable
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable();
            }
            if (!Schema::hasColumn('users', 'bio')) {
                $table->text('bio')->nullable();
            }
        });
    }
};
