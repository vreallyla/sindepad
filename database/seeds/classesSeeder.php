<?php

use Illuminate\Database\Seeder;

class classesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class['name'] = [
            'Menyanyi',
            'Menari',
            'Jimbe',
            'Olahraga',
            'Bermain',
            'Membaca',
            'Menulis',
            'Berhitung',
            'Melukis/Mewarnai',
            'Mengaji',
            'Fotografi'
        ];
        $class['url'] = [
            'storage/icon-class/sing.png',
            'storage/icon-class/dancing.png',
            'storage/icon-class/music.png',
            'storage/icon-class/boxing.png',
            'storage/icon-class/happy.png',
            'storage/icon-class/reading.png',
            'storage/icon-class/drawing.png',
            'storage/icon-class/berhitung.png',
            'storage/icon-class/artist.png',
            'storage/icon-class/angel.png',
            'storage/icon-class/photographer.png'
        ];
        for ($i=0;$i<count($class['name']);$i++) {
            \App\Model\mstClass::create(['name' => $class['name'][$i], 'url' => $class['url'][$i],
                'detail' => 'Plusieurs variations de Lorem Ipsum peuvent être trouvées ici ou là, mais la majeure partie d\'entre elles a été altérée par l\'addition d\'humour ou de mots aléatoires qui ne ressemblent pas une seconde à du texte standard.']);
        }
    }
}
