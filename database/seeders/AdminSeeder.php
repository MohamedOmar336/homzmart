<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('admins')->truncate();
        Admin::create([
            'user_name' => 'Bawabt alsharq',
            'email' => 'SuperAdmin@mail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
