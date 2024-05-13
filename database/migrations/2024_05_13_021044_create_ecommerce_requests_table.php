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
        Schema::create('ecommerce_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->default(0)->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('domain');
            $table->enum('business_type', ['B2C', 'B2B', 'B2B Plus']);
            $table->string('vat_number');
            $table->string('email');
            $table->string('company_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ecommerce_requests');
    }
};
