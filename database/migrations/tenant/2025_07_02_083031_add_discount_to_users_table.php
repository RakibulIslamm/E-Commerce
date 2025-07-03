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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'discount')) {
            Schema::table('users', function (Blueprint $table) {
                $table->decimal('discount', 5, 2)->default(0)->after('price_list');
            });
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'discount')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('discount');
            });
        }
    }
};
