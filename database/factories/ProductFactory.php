<?php

namespace Database\Factories;

use App\Constants\IStatus;
use App\Models\Addon;
use App\Models\Brand;
use App\Models\Business;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = ProductFactory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $business_id = Business::get()->random(1)->first()->id;
        return [
            'business_id' => $business_id,
            'title' => $this->faker->word,
            'description' => $this->faker->text,
            'cost_price' => $this->faker->randomFloat(),
            'retail_price' => $this->faker->randomFloat(),
            'discounted_price' => $this->faker->randomFloat(),
            'barcode' => $this->faker->word,
            'sku' => $this->faker->word,
            'has_addons_or_variants' => $this->faker->randomNumber(),
            'is_active' => IStatus::ACTIVE,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'addons' => Addon::whereBusinessId($business_id)->first()->id,
            'brand' => $this->faker->word,
            'categories' => $this->faker->word,
            'images' => $this->faker->image(),
            'stores' => $this->faker->word,
            'variants' => $this->faker->word,
            'brand_id' => function () {
                return Brand::factory()->create()->id;
            },
        ];
    }

    public function addAddon($product_id)
    {

    }
}
