<?php

use Illuminate\Database\Seeder;

class payMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
//            'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
            'name' => 'Bayar Ditempat',
            'url' => 'images/paying-method/langsung.png',
            'desc'=>'Pembayaran dapat dilakukan di tempat Sanggar ABK',
            'method' => 'Bayar Ditempat',
            'created_at'=>now(),
            'updated_at'=>now()
        ], [
//            'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
            'name' => 'BNI',
            'url' => 'images/paying-method/bni.png',
            'method' => 'Transfer',
            'name_owner' => 'Sanggar ABK',
            'division' => 'Selatan',
            'no_rek'=>'230948230498409849',
            'created_at'=>now()->addSecond(3),
            'updated_at'=>now()->addSecond(3),
            'bank_id'=>\App\Model\general\dataBank::where('name','BANK BNI')->first()->id
        ]];
        foreach ($data as $row) {
            \App\Model\order\payingMethod::create($row);
        }



    }
}
