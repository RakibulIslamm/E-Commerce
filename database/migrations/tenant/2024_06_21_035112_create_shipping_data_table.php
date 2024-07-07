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
        Schema::create('shipping_data', function (Blueprint $table) {
            $table->id();
            $table->string('courier');
            $table->decimal('minimum_spend', 8, 2)->nullable()->default(0); // Including VAT
            $table->decimal('marking_costs', 8, 2)->nullable()->default(0);
            $table->decimal('vat_value', 8, 2)->nullable()->default(0);
            $table->decimal('shipping_italy_until', 8, 2)->nullable()->default(0);
            $table->decimal('shipping_italy_charge', 8, 2)->nullable()->default(0);
            $table->decimal('shipping_major_islands_until', 8, 2)->nullable()->default(0);
            $table->decimal('shipping_major_islands_charge', 8, 2)->nullable()->default(0);
            $table->decimal('shipping_smaller_islands_until', 8, 2)->nullable()->default(0);
            $table->decimal('shipping_smaller_islands_charge', 8, 2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_data');
    }
};
