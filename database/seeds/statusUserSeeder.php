<?php

use Illuminate\Database\Seeder;

class statusUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x['ind']=['Admin','Pengajar','User'];
        $x['en']=['Admin','Teacher','User'];

        for ($i = 0; $i < count($x['ind']); $i++) {
           \App\Model\sideStatusUser::create(['ind' => $x['ind'][$i], 'eng' => $x['en'][$i],
                'detail' => 'Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d\'entre elles a été altérée par l\'addition d\'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard.']);
        }
    }
}
