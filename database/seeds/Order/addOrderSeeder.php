<?php

use Illuminate\Database\Seeder;

class addOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $time=\App\Model\Order\timeOption::inRandomOrder()->first();
        for ($i=0;$i<15;$i++) {
            \App\Model\Order\rs\rsStudentNOptionTime::create([
                'time_id'=>$time->id,
                'user_id'=>\App\User::inRandomOrder()->first()->id
            ]);
        }
    }
}
