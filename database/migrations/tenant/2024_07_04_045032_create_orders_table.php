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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('n_ordine');
            $table->date('data_ordine');
            $table->string('promo')->nullable();
            $table->string('nominativo')->nullable();
            $table->string('ragione_sociale')->nullable();
            $table->string('indirizzo')->nullable();
            $table->string('cap')->nullable();
            $table->string('citta')->nullable();
            $table->string('provincia')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->integer('stato')->default(-1);
            $table->boolean('pagamento')->default(false);
            $table->decimal('totale_netto', 10, 2)->nullable();
            $table->decimal('totale_iva', 10, 2)->nullable();
            $table->decimal('promo_netto', 10, 2)->nullable();
            $table->decimal('promo_iva', 10, 2)->nullable();
            $table->decimal('spese_spedizione', 10, 2)->nullable();
            $table->string('nominativo_spedizione')->nullable();
            $table->string('ragione_sociale_spedizione')->nullable();
            $table->string('indirizzo_spedizione')->nullable();
            $table->string('cap_spedizione')->nullable();
            $table->string('citta_spedizione')->nullable();
            $table->string('provincia_spedizione')->nullable();
            $table->string('pec')->nullable();
            $table->string('sdi')->nullable();
            $table->text('note')->nullable();
            $table->string('corriere')->nullable();
            $table->boolean('downloaded')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
