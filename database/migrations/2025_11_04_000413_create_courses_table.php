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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('code', 50)->unique()->nullable();
            $table->text('description')->nullable();
            $table->string('grade_level', 50)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();

            // Índices para mejorar búsquedas
            $table->index('name');
            $table->index('grade_level');
            $table->index('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
