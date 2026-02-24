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
        Schema::create('pins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('image_url');
            $table->string('link')->nullable();
            $table->string('board')->nullable();
            $table->text('alt_text')->nullable();
            $table->boolean('allow_comments')->default(true);
            $table->boolean('show_similar')->default(true);
            $table->string('mongo_id')->nullable()->comment('ID del documento en MongoDB');
            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Índices
            $table->index('user_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pins');
    }
};
