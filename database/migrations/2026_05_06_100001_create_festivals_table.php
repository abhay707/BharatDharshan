<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('festivals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tagline');
            $table->foreignId('state_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_national')->default(false);
            $table->enum('religion', [
                'Hindu', 'Muslim', 'Sikh', 'Christian',
                'Buddhist', 'Jain', 'Tribal', 'Secular', 'Other',
            ]);
            $table->tinyInteger('month');
            $table->tinyInteger('start_day')->nullable();
            $table->tinyInteger('end_day')->nullable();
            $table->tinyInteger('duration_days');
            $table->text('short_description');
            $table->longText('full_description');
            $table->text('significance');
            $table->text('how_celebrated');
            $table->string('cover_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('festivals');
    }
};
