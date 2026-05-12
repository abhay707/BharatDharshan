<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('festival_tips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('festival_id')->constrained()->cascadeOnDelete();
            $table->enum('tip_category', [
                'What_to_Wear', 'What_to_Eat', 'What_to_Carry',
                'Photography', 'Safety', 'Transport', 'Etiquette', 'Best_Spots',
            ]);
            $table->string('tip_title');
            $table->text('tip_body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('festival_tips');
    }
};
