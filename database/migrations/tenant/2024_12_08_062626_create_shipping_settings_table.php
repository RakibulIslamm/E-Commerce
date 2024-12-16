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
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            $table->string('courier')->nullable();
            $table->decimal('minimum_order', 8, 2)->default(0);
            $table->decimal('cod_fee', 8, 2)->default(0);
            $table->decimal('vat_rate', 5, 2)->default(22);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_settings');
    }
};
