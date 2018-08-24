<?php

use Illuminate\Database\Seeder;

class salarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $range=['< Rp. 500.000,.','Rp. 500.000,. - Rp. 999.999,.',
            'Rp. 1.000.000,. - Rp. 1.999.999,.',
            'Rp. 2.000.000,. - Rp. 4.999.999,.',
            'Rp. 5.000.000,. - Rp. 9.999.999,.',
            'Rp. 10.000.000,. - Rp. 20.000.000,.',
            ];
        for ($i=0;$i<count($range);$i++){
            \App\Model\sideSalaryList::create(['range'=>$range[$i]]);
        }
    }
}
