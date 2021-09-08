<?php

namespace Database\Seeders;

use App\Constants\IStatus;
use App\Models\DeliveryCompany;
use Illuminate\Database\Seeder;

class DeliveryCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'title' => 'Tawseel',
                'contact_person' => 'Tawseel',
                'contact_email' => 'info@tawseel.ae',
                'contact_phone' => '971600503321',
                'address' => 'Al Tunaiji Buidling (Thumbay Hospital), Office 301, Muweilah Commercial, Sharjah, UAE'
            ],

        ];
        foreach ($companies as $company) {
            if (!DeliveryCompany::where(['title' => $company['title'], 'contact_email' => $company['contact_email']])->first()) {
                $deliveryCompany = new DeliveryCompany();
                $deliveryCompany->title = $company['title'];
                $deliveryCompany->contact_person = $company['contact_person'];
                $deliveryCompany->contact_email = $company['contact_email'];
                $deliveryCompany->contact_phone = $company['contact_phone'];
                $deliveryCompany->address = $company['address'];
                $deliveryCompany->is_active = IStatus::ACTIVE;
                $deliveryCompany->save();
            }

        }
    }
}
