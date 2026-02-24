<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('user_profiles', 'avatar_url')) {
                $table->string('avatar_url', 2000)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('user_profiles', 'cover_url')) {
                $table->string('cover_url', 2000)->nullable()->after('avatar_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('user_profiles', 'cover_url')) {
                $table->dropColumn('cover_url');
            }
            if (Schema::hasColumn('user_profiles', 'avatar_url')) {
                $table->dropColumn('avatar_url');
            }
        });
    }
};

