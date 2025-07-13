<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Questa migration gira su OGNI database tenant
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // PIN personale per l'app mobile (4 cifre)
            $table->string('mobile_pin', 4)
                  ->nullable()
                  ->after('active')
                  ->comment('PIN di 4 cifre per accesso app mobile');
            
            // Flag per abilitare accesso mobile per questo utente
            $table->boolean('mobile_access_enabled')
                  ->default(false)
                  ->after('mobile_pin')
                  ->comment('Abilita accesso da app mobile per questo utente');
            
            // Timestamp ultimo accesso mobile (opzionale)
            $table->timestamp('last_mobile_login')
                  ->nullable()
                  ->after('mobile_access_enabled')
                  ->comment('Ultimo accesso da app mobile');
            
            // Indice per ricerche veloci
            $table->index(['mobile_pin', 'mobile_access_enabled'], 'idx_mobile_access');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Rimuovi l'indice prima di eliminare le colonne
            $table->dropIndex('idx_mobile_access');
            
            // Rimuovi le colonne
            $table->dropColumn([
                'mobile_pin',
                'mobile_access_enabled',
                'last_mobile_login'
            ]);
        });
    }
};