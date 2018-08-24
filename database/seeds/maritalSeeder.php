<?php

use Illuminate\Database\Seeder;

class maritalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x['en']=['Single','Married','Rather Not Say'];
        $x['id']=['Lajang','Menikah','Lainnya'];
        for ($i=0;$i<count($x['id']);$i++){
            \App\Model\sideMaritalStatus::create(['ind'=>$x['id'][$i], 'en'=>$x['en'][$i]]);
        }
    }
}
