<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Product;
use Illuminate\Database\Seeder;

class UpdateProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $businesses = Business::all();

        foreach ($businesses as $business){
            $products = Product::whereBusinessId($business->id)->get();
            foreach ($products as $product) {
                $product->product_type = $business->business_type_id;
                $product->save();
            }
        }
    }
}
