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
            \App\Model\sideMaritalStatus::insert([
                'id'=>(string)\Webpatser\Uuid\Uuid::generate(4),
                'ind'=>$x['id'][$i],
                'en'=>$x['en'][$i],
                'created_at'=>now()->addSecond($i),
                'updated_at'=>now()->addSecond($i)
            ]);
        }
    }
}
