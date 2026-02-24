<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'email')) {
            return;
        }

        DB::statement('ALTER TABLE users ALTER COLUMN email TYPE VARCHAR(255)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('users') || !Schema::hasColumn('users', 'email')) {
            return;
        }

        DB::statement('ALTER TABLE users ALTER COLUMN email TYPE VARCHAR(50)');
    }
};
