<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('state_cultures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('states')->cascadeOnDelete();
            $table->text('classical_dance')->nullable();
            $table->text('music_forms')->nullable();
            $table->string('traditional_dress_male')->nullable();
            $table->string('traditional_dress_female')->nullable();
            $table->text('art_forms')->nullable();
            $table->text('handicrafts')->nullable();
            $table->string('language_script')->nullable();
            $table->text('notable_personalities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('state_cultures');
    }
};
