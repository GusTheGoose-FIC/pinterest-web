<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('saved_pins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pin_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('pin_id')->references('id')->on('pins')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['pin_id', 'user_id']);
            $table->index('pin_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('saved_pins');
    }
};

