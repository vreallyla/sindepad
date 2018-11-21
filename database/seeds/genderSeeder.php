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
        $x['ind'] = ['Laki-Laki', 'Perempuan', 'Lainnya'];
        $x['en'] = ['Male', 'Female', 'Rather Not Say'];
        for ($i = 0; $i < count($x['ind']); $i++) {
            \App\Model\sideGender::create([
                'id'=>(string)\Webpatser\Uuid\Uuid::generate(4),
                'ind' => $x['ind'][$i],
                'en' => $x['en'][$i],
                'created_at'=>now()->addSecond($i),
                'updated_at'=>now()->addSecond($i)
            ]);
        }
    }
}
