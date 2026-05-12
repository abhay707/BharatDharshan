<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('capital');
            $table->enum('region', ['North', 'South', 'East', 'West', 'Northeast', 'Central']);
            $table->string('language');
            $table->text('description');
            $table->date('established_date')->nullable();
            $table->bigInteger('population')->nullable();
            $table->decimal('area_sq_km', 12, 2)->nullable();
            $table->string('cover_image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
