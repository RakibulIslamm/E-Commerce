<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedById;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('country_code');
            $table->string('zipcode', 10);
            $table->string('place');
            $table->string('state');
            $table->string('state_code');
            $table->string('province');
            $table->string('province_code');
            $table->string('community')->nullable();
            $table->string('community_code')->nullable();
            $table->decimal('latitude');
            $table->decimal('longitude');
            $table->timestamps();
        });

        // tenant()->run(function (){
        //     try {
        //         $path = database_path('sql/locations.sql');
        //         if(file_exists($path)){
        //             $sql = file_get_contents($path);
        //             DB::unprepared($sql);
        //         }
        //     } catch (TenantCouldNotBeIdentifiedById $e) {
        //         logger()->error('Tenant not identified: ' . $e->getMessage());
        //     }
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
