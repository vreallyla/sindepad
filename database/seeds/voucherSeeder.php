<?php

use Illuminate\Database\Seeder;

class voucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\order\voucherRegister::create([
           'code'=>'rahasia',
           'amount'=>'25',
           'type'=>'Diskon',
           'expired'=>now()->addMonth(1)
        ]);
    }
}
