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
        Schema::create('monument_tips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monument_id')->constrained('monuments')->cascadeOnDelete();
            $table->text('tip');
            $table->enum('tip_type', [
                'General', 'Photography', 'Transport',
                'Clothing', 'Food', 'Timing',
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monument_tips');
    }
};
