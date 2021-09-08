<?php

namespace Database\Factories;

use App\Models\Business;
use App\Models\Customer;
use App\Models\Discount;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_number' => $this->faker->randomDigit(),
            'customer_id' => Customer::all()->random(1)->first()->id,
            'store_id' => Store::whereBusinessId(1)->get()->random(1)->first()->id,
            'business_id' => 1,
            'subtotal' => rand(1.00,100.00),
            'discount_code' => null,
            'discount_type' => null,
            'discount_value' => 0.00,
            'discount' => 0.00,
            'tax' => rand(1.00,15.00),
            'total' => rand(1.00,150.00),
            'refunded_amount' => 0,
            'refund_reason' => null,
            'delivery_charges' => 0,
            'delivery_company_id' => 1,
            'is_gift' => 0,
            'customer_notes' => $this->faker->text(),
            'payment_type_id' => rand(1,4),
            'payment_method_id' => rand(1,4),
            'payment_status_id'=> rand(1,4),
            'fulfilment_status_id'=> rand(1,4),
            'order_status_id'=> rand(1,4),
        ];
    }
}
