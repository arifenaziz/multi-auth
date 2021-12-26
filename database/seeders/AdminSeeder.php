<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin=Admin::where('email','super@gmail.com')->first();

        if(is_null($admin)){
            $admin=new Admin();
            $admin->name="Super Admin";
            $admin->username="superadmin";
            $admin->email="super@gmail.com";
            $admin->password=Hash::make('super123');
            $admin->save();
            $admin->assignRole('Super Admin');

        }
    }
}
