<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('plans')->insert([
            'name' => 'Plan_one',
            'price' => 999,
            'billing_period' => 'monthly',
            'stripe_plan_id'=>'price_1KgBDmJPFUiHiUaXIeiR3jKU'

        ]);
        DB::table('plans')->insert([
            'name' => 'Plan_two',
            'price' => 9999,
            'billing_period' => 'yearly',
            'stripe_plan_id'=>'price_1KgBE7JPFUiHiUaXjtD8yV2R'

        ]);
    }
}
