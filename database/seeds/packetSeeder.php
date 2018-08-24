<?php

use Illuminate\Database\Seeder;

class packetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x['name']=['Starter','Professional','Bussiness','Interprise'];
        $x['amount']=['125.000','150.000','175.000','200.000'];
        for ($i=0;$i<count($x['name']);$i++){
            \App\Model\mstDataPaket::create(['name'=>$x['name'][$i],'amount'=>$x['amount'][$i],'regist'=>200.000
                ,'detail'=>'On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte.']);
        }
    }
}
