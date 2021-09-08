<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'email' => $this->faker->unique()->email,
            'phone' => rand(1,15),
            'mobile' => rand(1,15),
            'address' => $this->faker->text,
            'zipcode' => rand(1,10),
            'country_id' => rand(1,5),
            'city_id' => rand(1,5),
            'fixed_discount' => rand(1,15),

        ];
    }
}
