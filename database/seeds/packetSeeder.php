<?php

use Illuminate\Database\Seeder;

class packetSeeder extends Seeder
{
    protected $no = 2;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $x = [
            [
                'name' => 'Uang Gedung',
                'price' => '5000000000'
            ], [
                'name' => 'Biaya Pendaftaran',
                'price' => '1000000000'
            ], [
                'name' => 'Biaya Bulanan',
                'price' => '2000000000'
            ],
        ];

        $type = \App\Model\order\sideTypePrice::create([
            'name' => 'Wajib'
        ]);

        foreach ($x as $i => $r) {
            $z = \App\Model\order\linkTransPrice::create([
                'name' => $r['name'],
                'amount' => $r['price'],
                'type_id' => $type->id
            ]);
        }

    }
}
