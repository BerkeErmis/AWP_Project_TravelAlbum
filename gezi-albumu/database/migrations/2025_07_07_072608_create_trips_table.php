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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Şehir adı
            $table->text('description'); // Gezi açıklaması
            $table->date('trip_date'); // Gezi tarihi
            $table->string('photo_path'); // Fotoğraf yolu
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Ekleyen admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
