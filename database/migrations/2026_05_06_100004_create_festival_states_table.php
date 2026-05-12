<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('festival_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('festival_id')->constrained()->cascadeOnDelete();
            $table->foreignId('state_id')->constrained()->cascadeOnDelete();
            $table->string('local_name')->nullable();
            $table->text('local_significance')->nullable();
            $table->timestamps();

            $table->unique(['festival_id', 'state_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('festival_states');
    }
};
