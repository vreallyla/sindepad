<?php

use Illuminate\Database\Seeder;

class timeOptionSeeder extends Seeder
{

    protected $no=1;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = \App\Model\sideDaylist::orderBy('created_at', 'asc')->get();
        $times = \App\Model\sideTimeList::orderBy('created_at', 'asc')->get();
        foreach ($days as $day) {
            foreach ($times as $i => $time) {
                $data[]=[
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'day_id' => $day->id,
                    'time_id' => $time->id,
                    'quota' =>15,
                    'created_at' => now()->addSecond($this->no+=1),
                    'updated_at' => now()->addSecond($this->no+=1)
                ];
            }}
        \App\Model\Order\timeOption::insert($data);
    }
}
