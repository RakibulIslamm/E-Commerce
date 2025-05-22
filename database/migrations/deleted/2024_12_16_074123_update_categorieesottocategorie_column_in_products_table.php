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
        Schema::table('products', function (Blueprint $table) {
        // Drop index or foreign key if it exists
            $table->dropForeign(['CATEGORIEESOTTOCATEGORIE']); // if it was a foreign key
            $table->dropIndex(['CATEGORIEESOTTOCATEGORIE']);   // if it was a plain index
        });

        Schema::table('products', function (Blueprint $table) {
            $table->json('CATEGORIEESOTTOCATEGORIE')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('CATEGORIEESOTTOCATEGORIE')->nullable()->change();
        });
    }
};
