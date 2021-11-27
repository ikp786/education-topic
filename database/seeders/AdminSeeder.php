<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::insert([
            'full_name'         => 'Topic & Doubts',
            'email_address'     => 'info@topic.com',
            'password'          => Hash::make('Anil#123!'),
        ]);
    }
}
