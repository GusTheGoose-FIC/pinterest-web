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
        // Esta migración se convierte en un ajuste no destructivo para evitar
        // conflictos con claves foráneas (p. ej., user_profiles.user_id).
        // Nos aseguramos de que la tabla users tenga las columnas necesarias
        // y no tenga columnas obsoletas, sin eliminar la tabla.

        // Asegurar columna 'date'
        if (!Schema::hasColumn('users', 'date')) {
            Schema::table('users', function (Blueprint $table) {
                $table->date('date')->after('password');
            });
        }

        // Eliminar columnas obsoletas si existiesen
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'username')) {
                try { $table->dropColumn('username'); } catch (\Throwable $e) {}
            }
            if (Schema::hasColumn('users', 'bio')) {
                try { $table->dropColumn('bio'); } catch (\Throwable $e) {}
            }
            if (Schema::hasColumn('users', 'name')) {
                try { $table->dropColumn('name'); } catch (\Throwable $e) {}
            }
            if (Schema::hasColumn('users', 'remember_token')) {
                try { $table->dropColumn('remember_token'); } catch (\Throwable $e) {}
            }
            if (Schema::hasColumn('users', 'email_verified_at')) {
                try { $table->dropColumn('email_verified_at'); } catch (\Throwable $e) {}
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Sin reversión específica; no destructivo
    }
};