<?php

use Illuminate\Database\Seeder;

class hariSeeder extends Seeder
{
    protected $no = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (range(1, 5) as $i) {
            setlocale(LC_TIME, 'id');
            $id = \Carbon\Carbon::create(2018, 9, 9)->addDays($i)->formatLocalized('%A');
            setlocale(LC_TIME, 'en');
            $en = \Carbon\Carbon::create(2018, 9, 9)->addDays($i)->formatLocalized('%A');
            \App\Model\sideDaylist::insert([
                'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                'ind' => $id,
                'en' => $en,
                'created_at' => now()->addSecond($this->no += $this->no),
                'updated_at' => now()->addSecond($this->no)
            ]);
        }
    }
}
