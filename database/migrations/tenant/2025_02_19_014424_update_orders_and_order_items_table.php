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
        Schema::table('orders', function (Blueprint $table) {
            // Renaming columns
            $table->renameColumn('promotion_id', 'promo');

            // Adding new columns
            $table->decimal('promo_netto', 10, 2)->nullable()->after('totale_iva');
            $table->decimal('promo_iva', 10, 2)->nullable()->after('promo_netto');
            $table->string('pec')->nullable()->after('provincia_spedizione');
            $table->string('sdi')->nullable()->after('pec');

            // Removing 'spedizione' column if it exists
            if (Schema::hasColumn('orders', 'spedizione')) {
                $table->dropColumn('spedizione');
            }
        });

        Schema::table('order_items', function (Blueprint $table) {
            // Renaming columns
            $table->renameColumn('price', 'imponibile');
            $table->renameColumn('vat', 'ivato');
            $table->renameColumn('quantity', 'qta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Reverting column names
            $table->renameColumn('promo', 'promotion_id');

            // Dropping newly added columns
            $table->dropColumn(['promo_netto', 'promo_iva', 'pec', 'sdi']);

            // Re-adding 'spedizione' if necessary
            $table->string('spedizione')->nullable();
        });

        Schema::table('order_items', function (Blueprint $table) {
            // Reverting column names
            $table->renameColumn('imponibile', 'price');
            $table->renameColumn('ivato', 'vat');
            $table->renameColumn('qta', 'quantity');
        });
    }
};

