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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Usuario que recibe la notificación
            $table->unsignedBigInteger('actor_id'); // Usuario que realizó la acción
            $table->unsignedBigInteger('pin_id'); // Pin relacionado
            $table->string('type'); // 'like', 'comment'
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->timestamps();
            
            // Índices
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('actor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('pin_id')->references('id')->on('pins')->onDelete('cascade');
            $table->index('user_id');
            $table->index('read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
