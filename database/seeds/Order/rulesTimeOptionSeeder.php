<?php

use Illuminate\Database\Seeder;

class rulesTimeOptionSeeder extends Seeder
{
    protected $no = 1;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classes = \App\Model\mstClass::whereIn('name', ['Menari', 'Jimbe', 'Olahraga'])->orderBy('name', 'asc')->get();
        $day = \App\Model\sideDaylist::whereIn('ind', ['Sabtu', 'Minggu'])->pluck('id');
        $timeOptions = \App\Model\Order\timeOption::whereIn('day_id', $day)->orderBy('created_at', 'asc')->get();

        foreach ($classes as $class) {
            foreach ($timeOptions as $time) {
                $data[] = [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'time_id' => $time->id,
                    'class_id' => $class->id,
                    'todo' => 'add',
                    'created_at' => now()->addSecond($this->no += 1),
                    'updated_at' => now()->addSecond($this->no += 1)
                ];
            }
        }

        \App\Model\Order\Setting\rulesTimeOption::insert($data);
    }
}
