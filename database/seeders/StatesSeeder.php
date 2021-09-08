<?php

namespace Database\Seeders;

use App\Constants\IStatus;
use App\Models\State;
use Illuminate\Database\Seeder;

class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->states() as $nameEn => $nameAr){
            $state = State::whereName($nameEn)->first();
            if (!$state){
                $state = new State();
                $state->name = $nameEn;
                $state->name_ar = $nameAr;
                $state->is_active = IStatus::ACTIVE;
                $state->country_code = 'AE';
                $state->save();
            }
        }
    }

    public function states()
    {
        return [
            'Abu Dhabi' => 'أبو ظبي',
            'Ajman' => 'عجمان',
            'Dubai' => 'دبي',
            'Fujairah' => 'الفجيرة',
            'Ras Al Khaimah' => 'رأس الخيمة',
            'Sharjah' => 'الشارقة',
            'Umm Al Quwain' => 'أم القيوين'
        ];
    }
}
