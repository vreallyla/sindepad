<?php

use Illuminate\Database\Seeder;

class hariSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (range(1, 7) as $i) {
            setlocale(LC_TIME, 'id');
            $id = \Carbon\Carbon::create(2018, 9, 4)->subDays($i)->formatLocalized('%A');
            setlocale(LC_TIME, 'en');
            $en = \Carbon\Carbon::create(2018, 9, 4)->subDays($i)->formatLocalized('%A');
            \App\Model\sideDaylist::create(['ind' => $id, 'en' => $en]);
        }
    }
}
