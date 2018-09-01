<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(provinceSeeder::class);
         $this->call(classesSeeder::class);
         $this->call(educationSeeder::class);
         $this->call(genderSeeder::class);
        $this->call(hariSeeder::class);
        $this->call(maritalSeeder::class);
        $this->call(occupationSeeder::class);
        $this->call(packetSeeder::class);
        $this->call(professionSeeder::class);
        $this->call(salarySeeder::class);
        $this->call(statusUserSeeder::class);
        $this->call(timeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(contactSeeder::class);
    }
}
