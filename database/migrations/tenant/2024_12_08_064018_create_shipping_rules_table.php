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
        Schema::create('shipping_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_setting_id')->constrained()->onDelete('cascade');
            $table->string('zone');
            $table->decimal('threshold', 8, 2);
            $table->decimal('fee', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rules');
    }
};
