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
        Schema::create('monuments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->constrained('states')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('short_description');
            $table->longText('full_description');
            $table->enum('type', [
                'Fort', 'Temple', 'Stepwell', 'Cave', 'Palace',
                'Mosque', 'Church', 'Stupa', 'Lake', 'Park',
                'Memorial', 'Other',
            ]);
            $table->enum('category', [
                'UNESCO', 'ASI', 'Religious', 'Natural', 'State_Protected',
            ]);
            $table->string('built_by')->nullable();
            $table->smallInteger('built_in_year')->nullable();
            $table->string('dynasty_or_period')->nullable();
            $table->decimal('entry_fee_indian', 8, 2)->nullable();
            $table->decimal('entry_fee_foreign', 8, 2)->nullable();
            $table->text('best_time_to_visit');
            $table->text('visiting_hours');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('address');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monuments');
    }
};
