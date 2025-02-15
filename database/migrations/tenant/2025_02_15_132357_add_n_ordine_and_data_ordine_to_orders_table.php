<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Check if the columns do not exist before adding them
        if (!Schema::hasColumn('orders', 'n_ordine')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('n_ordine')->after('id')->nullable();
            });
        }

        if (!Schema::hasColumn('orders', 'data_ordine')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->timestamp('data_ordine')->after('created_at')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Use dropIfExists to avoid errors if columns don't exist
            $table->dropColumn('n_ordine');
            $table->dropColumn('data_ordine');
        });
    }
};
