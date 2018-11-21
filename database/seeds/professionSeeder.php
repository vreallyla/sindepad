<?php

use Illuminate\Database\Seeder;

class professionSeeder extends Seeder
{
    protected $no=2;

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
            \App\Model\sideProfessionList::insert([
                'id'=>(string)\Webpatser\Uuid\Uuid::generate(4),
                'ind'=>$x['ind'][$i], 'en'=>$x['en'][$i],
            'created_at'=>now()->addSecond($this->no+=$i),
            'updated_at'=>now()->addSecond($this->no+=$i)
            ]);
        }
    }
}
