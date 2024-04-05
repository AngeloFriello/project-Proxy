<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker, Payment $payment)
    {

        for ($i = 0; $i < 100; $i++) {
            $new_payment = new Payment();
            $new_payment->client_name = $faker->name();
            $new_payment->description = $faker->paragraph();
            $new_payment->total_price = $faker->randomFloat();
            $new_payment->user_id = 1;
            $new_payment->save();
        }
    }
}
