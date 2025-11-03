<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Postgres: drop NOT NULL constraint on image_url
        DB::statement('ALTER TABLE pins ALTER COLUMN image_url DROP NOT NULL');
    }

    public function down(): void
    {
        // Revert: set NOT NULL back (will fail if rows exist with NULLs)
        DB::statement('ALTER TABLE pins ALTER COLUMN image_url SET NOT NULL');
    }
};
