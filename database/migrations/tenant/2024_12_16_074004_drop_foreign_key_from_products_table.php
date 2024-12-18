<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropForeign(['CATEGORIEESOTTOCATEGORIE']);
        // });

        Schema::table('products', function (Blueprint $table) {
            $foreignKeys = DB::select("SHOW KEYS FROM products WHERE Key_name = 'products_categorieesottocategorie_foreign'");
            if (!empty($foreignKeys)) {
                $table->dropForeign('products_categorieesottocategorie_foreign');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('CATEGORIEESOTTOCATEGORIE')->references('id')->on('categories');
        });
    }
};
