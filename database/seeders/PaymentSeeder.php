<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentDetail;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentDetail::updateOrCreate(
            ['id' => 1],
            [
                'vpa' => 'yourname@VPA',
            ]
        );
    }
}
