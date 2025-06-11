<?php

namespace App\Jobs;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SeedTenantJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function handle(): void
    {
        $this->tenant->run(function () {
            // Create the admin user
            User::create([
                'name' => $this->tenant->auth_username,
                'email' => $this->tenant->email,
                'password' => $this->tenant->auth_password,
                'role' => 1,
            ]);

            // Import locations data
            $this->importLocations();
        });
    }

    protected function importLocations(): void
    {
        $path = base_path('locations.sql');
        
        if (!File::exists($path)) {
            throw new \Exception("Locations SQL file not found at: {$path}");
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $sql = File::get($path);
        
        // Split and filter out ALTER TABLE statements
        $statements = array_filter(
            explode(';', $sql),
            function ($statement) {
                $statement = trim($statement);
                return !empty($statement) && 
                    !str_starts_with(strtoupper($statement), 'ALTER TABLE') &&
                    !str_starts_with(strtoupper($statement), 'CREATE INDEX');
            }
        );

        foreach ($statements as $statement) {
            try {
                DB::statement($statement);
            } catch (\Exception $e) {
                // Log error but continue
                Log::error("Failed to execute SQL statement: " . $e->getMessage());
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}