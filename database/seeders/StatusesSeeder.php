<?php

namespace Database\Seeders;

use App\Constants\IStatus;
use App\Models\Business;
use App\Models\FulfillmentStatus;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class StatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Don't change the structure of this function.
        // It depends on the whole application
        // They are constants and cannot be changed

        $defaultStatus = $this->defaultStatus();
        $businessStatus = $this->businessStatus();
        $userStatus = $this->userStatus();
        $orderStatus = array_merge($this->fulfilmentStatus(), $this->paymentStatus());

        $statuses = array_merge($defaultStatus, $businessStatus, $userStatus, $orderStatus);

        foreach ($statuses as $status){
            $existingStatus = Status::whereTitle($status['title'])->whereType($status['type'])->first();
            if (!$existingStatus){
                $model = new Status();
                $model->title = $status['title'];
                $model->type = $status['type'];
                $model->is_active = IStatus::ACTIVE;
                $model->sort = isset($status['sort']) ? $status['sort'] : 0;
                $model->save();
            }
        }
    }

    public function defaultStatus()
    {
        return [
            [
                'title' => 'Active',
                'type' => '',
                'is_active' => 1
            ],
            [
                'title' => 'Disable',
                'type' => '',
                'is_active' => 1
            ]
        ];
    }

    public function businessStatus()
    {
        return [
            [
                'title' => 'Active',
                'type' => Business::class,
                'is_active' => 1
            ],
            [
                'title' => 'InActive',
                'type' => Business::class,
                'is_active' => 1
            ],
            [
                'title' => 'Pending',
                'type' => Business::class,
                'is_active' => 1
            ],
            [
                'title' => 'Suspended',
                'type' => Business::class,
                'is_active' => 1
            ],
        ];
    }

    public function userStatus()
    {
        return [
            [
                'title' => 'Pending',
                'type' => User::class,
                'is_active' => 1
            ],
            [
                'title' => 'Active',
                'type' => User::class,
                'is_active' => 1
            ],
            [
                'title' => 'Disable',
                'type' => User::class,
                'is_active' => 1
            ]
        ];
    }
/*
    public function orderStatus()
    {
        return [
            [
                'title' => 'Order Placed',
                'type' => OrderStatus::class,
                'is_active' => 1,
                'sort' => 1,
            ],
            [
                'title' => 'Cancelled',
                'type' => OrderStatus::class,
                'is_active' => 1,
                'sort' => 6,
            ],
        ];
    }*/

    public function fulfilmentStatus()
    {
        return [
            [
                'title' => 'Order Placed',
                'type' => FulfillmentStatus::class,
                'is_active' => 1,
                'sort' => 1,
            ],
            [
                'title' => 'Processing',
                'type' => FulfillmentStatus::class,
                'is_active' => 1,
                'sort' => 3,
            ],
            [
                'title' => 'Fulfilled',
                'type' => FulfillmentStatus::class,
                'is_active' => 1,
                'sort' => 4,
            ],
            [
                'title' => 'Out for Delivery',
                'type' => FulfillmentStatus::class,
                'is_active' => 1,
                'sort' => 5,
            ],
            [
                'title' => 'Delivered',
                'type' => FulfillmentStatus::class,
                'is_active' => 1,
                'sort' => 6,
            ],
            [
                'title' => 'Returned',
                'type' => FulfillmentStatus::class,
                'is_active' => 1,
                'sort' => 7,
            ],
            [
                'title' => 'Cancelled',
                'type' => FulfillmentStatus::class,
                'is_active' => 1,
                'sort' => 8,
            ],
        ];
    }

    public function paymentStatus()
    {
        return [
            [
                'title' => 'Payment Pending',
                'type' => PaymentStatus::class,
                'is_active' => 1,
                'sort' => 0,
            ],
            [
                'title' => 'Paid',
                'type' => PaymentStatus::class,
                'is_active' => 1,
                'sort' => 2,
            ],
            [
                'title' => 'Refunded',
                'type' => PaymentStatus::class,
                'is_active' => 1,
                'sort' => 9,
            ]
        ];
    }
}
