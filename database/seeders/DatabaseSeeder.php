<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {   
        // $faker = Faker::create();

        

        DB::table('admin')->insert([
            'admin_name' => 'Site Admin',
            'admin_email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('123456'),
        ]);

        DB::table('general_settings')->insert([
            'com_name' => 'Payroll Management',
            'com_logo' => '472430997.png',
            'com_email' => 'company@email.com',
            'com_phone' => '0987654321',
            'address' => 'Ava Line 8569, New York',
            'copyright_text' => 'Copyright © 2021-2022',
            'cur_format' => '$',
            'clock_in_time' => '09:00:00',
            'clock_out_time' => '17:00:00',
        ]);

        DB::table('tax_rule')->insert([
            [
                'total_income' => '250000',
                'tax_rate' => '5',
                'taxable_amount' => '12500'
            ],
            [
                'total_income' => '500000',
                'tax_rate' => '10',
                'taxable_amount' => '50000'
            ],
            [
                'total_income' => '1200000',
                'tax_rate' => '15',
                'taxable_amount' => '180000'
            ],
            [
                'total_income' => '2500000',
                'tax_rate' => '25',
                'taxable_amount' => '625000'
            ],
            [
                'total_income' => '10000000',
                'tax_rate' => '30',
                'taxable_amount' => '3000000'
            ],
        ]);

        DB::table('salary_deduction_for_late')->insert([
            'for_days' => '1',
            'days_of_salary' => '3',
            'status' => '1',
        ]);
       
    }
}
