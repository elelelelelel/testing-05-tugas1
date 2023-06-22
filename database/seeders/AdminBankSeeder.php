<?php

namespace Database\Seeders;

use App\Models\AdminBank;
use Illuminate\Database\Seeder;

class AdminBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminBank::create([
            'bank_name' => 'MANDIRI',
            'bank_number' => '123-123-123',
            'bank_holder' => 'Admin E-Review'
        ]);
        AdminBank::create([
            'bank_name' => 'BCA',
            'bank_number' => '456-456-456',
            'bank_holder' => 'Admin E-Review'
        ]);
        AdminBank::create([
            'bank_name' => 'BRI',
            'bank_number' => '789-789-789',
            'bank_holder' => 'Admin E-Review'
        ]);
    }
}
