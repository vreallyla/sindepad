<?php

use Illuminate\Database\Seeder;

class timeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time['start'] = ['08:15:00', '09:20:00', '10:25:00', '13:00:00', '14:05:00', '15:10:00', '16:15:00'];
        $time['end'] = ['09:15:00', '10:20:00', '11:25:00', '14:00:00', '14:05:00', '16:10:00', '17:17:00'];
        for ($i = 0; $i < count($time['start']); $i++) {
            \App\Model\sideTimeList::insert([
                'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                'start' => $time['start'][$i], 'end' => $time['end'][$i],
                'created_at' => now()->addSecond($i),
                'updated_at' => now()->addSecond($i)
            ]);
        }

    }
}
