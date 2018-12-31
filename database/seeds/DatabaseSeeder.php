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
//         $this->call(provinceSeeder::class);
        //needed
        $this->call(classesSeeder::class);
        $this->call(educationSeeder::class);
        $this->call(genderSeeder::class);
        $this->call(hariSeeder::class);
        $this->call(maritalSeeder::class);
        $this->call(packetSeeder::class);
        $this->call(professionSeeder::class);
        $this->call(salarySeeder::class);
        $this->call(statusUserSeeder::class);
        $this->call(timeSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(contactSeeder::class);
        $this->call(disabilitySeeder::class);
        $this->call(hubSeeder::class);
        $this->call(voucherSeeder::class);
        $this->call(bankSeeder::class);
        $this->call(payMethodSeeder::class);
        $this->call(noteSeeder::class);
        $this->call(catInfoSeeder::class);
        //end needed

//        $this->call(occupationSeeder::class);


//        $this->call(timeOptionSeeder::class);
//        $this->call(rulesTimeOptionSeeder::class);
//        $this->call(addOrderSeeder::class);



    }
}
