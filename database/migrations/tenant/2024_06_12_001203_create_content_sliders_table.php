<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('content_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('link');
            $table->string('link_text');
            $table->string('title');
            $table->text('description');
            $table->string('img');
            $table->unsignedInteger('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_sliders');
    }
};
