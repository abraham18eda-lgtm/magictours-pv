<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tour_id')->constrained('tours')->onDelete('cascade');
            $table->string('locale', 5); // 'en', 'es', etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('amenities')->nullable();
            $table->text('faq')->nullable();
            $table->text('info')->nullable();
            $table->timestamps();

            $table->unique(['tour_id', 'locale']); // Evita duplicados por idioma
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_translations');
    }
};
