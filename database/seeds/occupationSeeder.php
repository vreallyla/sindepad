<?php

use Illuminate\Database\Seeder;

class occupationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $x=['Mahasiswa/i','Guru','Siswa/i'];
        for ($i=0;$x<count($x);$i++) {
            \App\Model\sideOccupation::create(['name' =>$x[$i],'detail'=>'On sait depuis longtemps que travailler avec du texte lisible et contenant du sens est source de distractions, et empêche de se concentrer sur la mise en page elle-même. L\'avantage du Lorem Ipsum sur un texte générique comme \'Du texte.']);
            }
    }
}
