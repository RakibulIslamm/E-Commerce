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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('code')->unique();
            $table->decimal('discount_amount', 8, 2)->nullable()->default(0);
            $table->integer('discount_percentage')->nullable()->default(0);
            $table->decimal('minimum_spend', 8, 2)->nullable()->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('active')->default(true);
            $table->string('bg_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
