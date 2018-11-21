<?php

use Illuminate\Database\Seeder;

class hubSeeder extends Seeder
{

    public function run()
    {
        $en = array('Parent', 'Kerabat', 'Custodian', 'Other');
        $id = array('Orang Tua', 'Kerabat', 'Wali', 'Lainnya');
        for ($i = 0; $i < count($id); $i++) {
            \App\mstHub::insert([
                'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                'ind' => $id[$i],
                'eng' => $en[$i],
                'created_at' => now()->addSecond($i),
                'updated_at' => now()->addSecond($i)
            ]);
        }

    }
}
