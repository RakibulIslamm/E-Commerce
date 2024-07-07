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
        Schema::create('products', function (Blueprint $table) {
            $table->id('IDARTICOLO');
            $table->string('BARCODE')->nullable();
            $table->string('DESCRIZIONEBREVE');
            $table->text('DESCRIZIONEESTESA');
            $table->decimal('ALIQUOTAIVA', 5, 2);
            $table->string('UNITAMISURA')->default('PZ');
            $table->integer('PXC')->default(1);
            $table->string('CODICELEGAME')->nullable();
            $table->string('MARCA')->nullable();
            $table->foreignId('CATEGORIEESOTTOCATEGORIE')->constrained('categories');
            $table->integer('GIACENZA')->default(0);
            $table->string('ARTICOLIALTERNATIVI')->nullable();
            $table->string('ARTICOLICORRELATI')->nullable();
            $table->boolean('NOVITA')->default(false);
            $table->boolean('PIUVENDUTI')->default(false);
            $table->boolean('VISIBILE')->default(false);
            $table->json('FOTO')->nullable();
            $table->decimal('PESOARTICOLO', 8, 3)->nullable();
            $table->string('TAGLIA')->nullable();
            $table->string('COLORE')->nullable();
            $table->decimal('PRE1IMP', 10, 2)->nullable();
            $table->decimal('PRE1IVA', 10, 2)->nullable();
            $table->decimal('PRE2IMP', 10, 2)->nullable();
            $table->decimal('PRE2IVA', 10, 2)->nullable();
            $table->decimal('PRE3IMP', 10, 2)->nullable();
            $table->decimal('PRE3IVA', 10, 2)->nullable();
            $table->decimal('PREPROMOIMP', 10, 2)->nullable();
            $table->decimal('PREPROMOIVA', 10, 2)->nullable();
            $table->date('DATAINIZIOPROMO')->nullable();
            $table->date('DATAFINEPROMO')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
