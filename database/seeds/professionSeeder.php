<?php

use Illuminate\Database\Seeder;
use App\professionList;

class professionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x['ind']=['Tidak Bekerja','Nelayan','Petani','Peternak','PNS/TNI/POLRI',
            'Karyawan Swasta', 'Pedagang','Wiraswasta','Buruh','Pensiunan','Meninggal','Lainya'];
        $x['en']=['Unemployed','Fisherman','Farmer','Breeder','Civil Employee/Soldier/Policeman',
            'private Employee','Tradesman','Entrepreneur','Labor','Pensionary',
            'Pass Away','Other'];
        for ($i=0;$i<count($x['ind']);$i++){
            \App\Model\sideProfessionList::create(['ind'=>$x['ind'][$i], 'en'=>$x['en'][$i]]);
        }
    }
}
