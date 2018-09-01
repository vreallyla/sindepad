<?php

use Illuminate\Database\Seeder;

class contactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\contact::create([
           'address'=>'QIS Surabaya (Kampung inggris Surabaya), Jalan Pesona Alam Gunung Anyar I B 12 No.25, Gunung Anyar, Surabaya City, East Java 60294',
           'lat'=>'-7.341407',
            'long'=> '112.793031',
            'phone'=> '+6282266027768'
        ]);
    }
}
