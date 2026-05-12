<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('state_cultures', function (Blueprint $table) {
            $table->text('traditional_dress_male')->nullable()->change();
            $table->text('traditional_dress_female')->nullable()->change();
            $table->text('language_script')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('state_cultures', function (Blueprint $table) {
            $table->string('traditional_dress_male')->nullable()->change();
            $table->string('traditional_dress_female')->nullable()->change();
            $table->string('language_script')->nullable()->change();
        });
    }
};
