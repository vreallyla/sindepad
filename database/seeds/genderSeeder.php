<?php

use Illuminate\Database\Seeder;

class genderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x['ind']=['Laki-Laki','Perempuan','Lainnya'];
        $x['en']=['Male','Female','Rather Not Say'];
        for ($i=0;$i<count($x['ind']);$i++){
            \App\Model\sideGender::create(['ind'=>$x['ind'][$i], 'en'=>$x['en'][$i]]);
        }
    }
}
