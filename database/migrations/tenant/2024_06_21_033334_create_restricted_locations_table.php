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
        Schema::create('restricted_locations', function (Blueprint $table) {
            $table->id();
            $table->string('code'); // e.g., "AG"
            $table->string('name'); // e.g., "AGRIGENTO"
            $table->string('postal_code'); // e.g., "92100"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restricted_locations');
    }
};
