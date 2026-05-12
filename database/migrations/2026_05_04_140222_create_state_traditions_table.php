<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('state_traditions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('states')->cascadeOnDelete();
            $table->string('name');
            $table->enum('category', ['Wedding', 'Festival', 'Harvest', 'Religious', 'Social', 'Art']);
            $table->text('description')->nullable();
            $table->text('significance')->nullable();
            $table->string('region_specific')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('state_traditions');
    }
};
