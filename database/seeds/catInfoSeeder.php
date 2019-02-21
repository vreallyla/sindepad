<?php

use Illuminate\Database\Seeder;

class catInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
        [
            'name'=>'Perawatan',
            'desc'=>'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis quo, sit. Cum debitis doloribus
                eaque esse facilis, impedit minus officia quo ut velit.'
        ],[
            'name'=>'Pencegahan',
            'desc'=>'Exercitationem fuga, itaque labore laborum minus nostrum perferendis praesentium quia quidem similique.'
        ],[
            'name'=>'Diagnosa',
            'desc'=>'Adipisci, aliquid asperiores debitis eligendi ex incidunt iste laudantium maxime nemo non placeat
                ratione recusandae saepe soluta veritatis!'
        ]
        ];

        foreach ($arr as $row){
            \App\Model\Admin\news\sideNewsCategory::create($row);
        }
    }
}
