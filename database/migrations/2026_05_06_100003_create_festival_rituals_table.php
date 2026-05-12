<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('festival_rituals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('festival_id')->constrained()->cascadeOnDelete();
            $table->string('ritual_name');
            $table->text('ritual_description');
            $table->string('ritual_timing')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('festival_rituals');
    }
};
