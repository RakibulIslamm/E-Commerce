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
        Schema::create('ecommerces', function (Blueprint $table) {
            $table->id();
            $table->string('business_name');
            $table->string('domain');
            $table->string('auth_username');
            $table->string('auth_password');
            $table->string('email');
            $table->string('tax_code');
            $table->string('phone');
            $table->string('rest_api_user');
            $table->string('rest_api_password');
            $table->enum('business_type', ['B2C', 'B2B', 'B2B Plus']);
            $table->boolean('price_with_vat')->default(false);
            $table->tinyInteger('decimal_places')->default(2);
            $table->boolean('size_color_options')->default(false);
            $table->enum('product_stock_display', ['Text Only', 'Text + Quantity', 'Do not display'])->default('Text Only');
            $table->enum('registration_process', ['Optional', 'Mandatory', 'Mandatory with confirmation'])->default('Optional');
            $table->json('accepted_payments')->default(json_encode(["PayPal", "Bank Transfer", "Cash on Delivery", "Collection and payment on site"]));
            $table->enum('offer_display', ['View cut price', 'Do not display the cut price'])->default('View cut price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecommerces');
    }
};
