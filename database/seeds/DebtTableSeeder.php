<?php

use Illuminate\Database\Seeder;

class DebtTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Debt::class, config('seeder.debts'))->create();
    }
}
