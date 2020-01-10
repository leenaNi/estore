<?php

use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('payment_method')->insert(
            ['name' => 'Cash', 'show_in_merchant_admin' => 1],
            ['name' => 'DD', 'show_in_merchant_admin' => 1],
            ['name' => 'Store Credit', 'show_in_merchant_admin' => 1],
            ['name' => 'Other', 'show_in_merchant_admin' => 1]
        );
    }
}
