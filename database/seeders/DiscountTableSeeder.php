<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('discount')->insert([
            'DiscountName' => 'Giảm giá mùa hè',
            'DiscountValue' => 10.00, // Ví dụ: giảm giá 10%
            'StartDate' => '2025-04-01',
            'EndDate' => '2025-06-30',
        ]);
    }
}
