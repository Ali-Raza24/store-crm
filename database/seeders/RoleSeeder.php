<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!Role::whereName('Super Admin')->first()){
            Role::create(['name' => 'Super Admin', 'is_business' => 0, 'business_id' => 0, 'guard_name' => 'web']);
        }

        $user = User::first();
        $user->assignRole('Super Admin');

        $users = User::whereIsBusiness(1)->get();

        foreach ($users as $user){
            $role = optional(optional($user->business)->plan)->role;

            if ($role) {
                $user->assignRole($role);
            }
        }
    }
}
