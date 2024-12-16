<?php
namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateCategorieesottocategorieData extends Command
{
    protected $signature = 'update:categorieesottocategorie';
    protected $description = 'Convert CATEGORIEESOTTOCATEGORIE to JSON format';

    public function handle()
    {

        $tenants = Tenant::all();
        tenancy()->runForMultiple($tenants, function(){
            DB::table('products')->whereNotNull('CATEGORIEESOTTOCATEGORIE')->get()->each(function ($product) {
                $categories = is_numeric($product->CATEGORIEESOTTOCATEGORIE)
                    ? [$product->CATEGORIEESOTTOCATEGORIE]
                    : json_decode($product->CATEGORIEESOTTOCATEGORIE, true);
    
                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['CATEGORIEESOTTOCATEGORIE' => json_encode($categories)]);
            });
    
            $this->info('CATEGORIEESOTTOCATEGORIE column updated successfully.');
        });
    }
}

