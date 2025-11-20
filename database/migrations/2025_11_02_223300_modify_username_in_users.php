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
        // Primero intentamos hacer la columna nullable
        if (Schema::hasColumn('users', 'username')) {
            try {
                DB::statement('ALTER TABLE users ALTER COLUMN username DROP NOT NULL');
            } catch (\Exception $e) {
                // Si falla, intentamos eliminar la columna
                Schema::table('users', function (Blueprint $table) {
                    try {
                        $table->dropColumn('username');
                    } catch (\Exception $e) {
                        // Si también falla, lo ignoramos - la columna podría no existir
                    }
                });
            }
        }

        // También intentamos con la columna bio
        if (Schema::hasColumn('users', 'bio')) {
            try {
                DB::statement('ALTER TABLE users ALTER COLUMN bio DROP NOT NULL');
            } catch (\Exception $e) {
                Schema::table('users', function (Blueprint $table) {
                    try {
                        $table->dropColumn('bio');
                    } catch (\Exception $e) {
                        // Ignoramos si falla
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No necesitamos revertir esto ya que queremos mantener estos campos en user_profiles
    }
};