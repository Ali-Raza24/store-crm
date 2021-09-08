<?php

namespace Database\Seeders;

use App\Constants\IStatus;
use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
            ['title' => 'Cash On Delivery'],
            ['title' => 'PayTabs'],
            ['title' => 'CCAvenue']
        ];

        foreach ($payments as $payment){
            if (!PaymentType::whereTitle($payment['title'])->first()){
                $paymentType = new PaymentType();
                $paymentType->title = $payment['title'];
                $paymentType->is_active = IStatus::ACTIVE;
                $paymentType->save();
            }
        }
    }
}
