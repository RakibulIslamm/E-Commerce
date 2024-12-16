<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateBase64ToUrlPath extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:update-base64-to-url-path';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convert Base64 encoded images in the FOTO column of products table to stored image paths.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenants = Tenant::all();

        tenancy()->runForMultiple($tenants, function () {
            DB::table('products')->whereNotNull('FOTO')->chunkById(100, function ($products) {
                foreach ($products as $product) {
                    try {
                        $photos = json_decode(json_decode($product->FOTO, true));
                        $images = [];
                        
                        if (is_array($photos)) {
                            foreach ($photos as $base64) {
                                $this->info("Inside");
                                if ($this->isBase64($base64)) {
                                    $decodedImage = base64_decode($base64);

                                    if ($decodedImage !== false) {
                                        $filename = uniqid('product_') . '_' . time() . '.png';
                                        $filePath = "uploads/products/{$filename}";
                                        Storage::disk('public')->put($filePath, $decodedImage);
                                        $images[] = $filePath;
                                    }
                                }
                            }
                        }
                        
                        if (!empty($images)) {
                            DB::table('products')->where('id', $product->id)->update(['FOTO' => json_encode(json_encode($images))]);
                        }
                    } catch (\Exception $e) {
                        $this->error("UpdateBase64ToUrlPath Error: " . $e->getMessage());
                        continue;
                    }
                }
            });

            $this->info('All eligible products processed successfully.');
        });
    }

    /**
     * Validate if a string is Base64 encoded.
     *
     * @param string $string
     * @return bool
     */
    private function isBase64($string)
    {
        if (preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $string)) {
            $decoded = base64_decode($string, true);

            return $decoded !== false && base64_encode($decoded) === $string;
        }

        return false;
    }
}
