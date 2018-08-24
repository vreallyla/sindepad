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
        $x['en'] = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];
        $x['id'] = [
            'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Minggu',
        ];
        for ($i=0;$i<count($x['id']);$i++){
            \App\Model\sideDaylist::create(['ind'=>$x['id'][$i], 'en'=>$x['en'][$i]]);
        }
    }
}
