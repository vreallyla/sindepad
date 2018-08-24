<?php

use Illuminate\Database\Seeder;

class educationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x['ind']=['SD','SMP','SMA/SMK','Sarjana','Magister','Doctor'];
        $x['en']=['Elementary','Junior High School','Senior High School','Bachelor','Master','Doctoral'];
        for ($i=0;$i<count($x['ind']);$i++){
            \App\Model\sideLastEducation::create(['ind'=>$x['ind'][$i], 'eng'=>$x['en'][$i]]);
        }
    }
}
