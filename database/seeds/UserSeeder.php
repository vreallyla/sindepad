<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\DeclaredPDO\photoUser as checkGender;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    const religion = ['Islam', 'Non Muslim'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('id_ID');


        \App\User::create([
            'name' => 'Fahmi Rizky M',
            'ni' => 50623024,
            'email' => 'vreallyla@gmail.com',
            'phone' => $faker->unique()->phoneNumber,
            'address' => $faker->unique()->address,
            'url' => 'storage/users/photo/j2wkBEHUaKyid7FKTdo1ME84qjG1ERpOxm0DaHKi.jpeg',
            'gender_id' => \App\Model\sideGender::where('en','Male')->first()->id,
            'code_status' => bcrypt(true),
            'status_id' => \App\Model\sideStatusUser::where('eng','Admin')->first()->id,
            'born_place' => $faker->city,
            'dob' => $faker->unique()->date('Y-m-d'),
            'password' => bcrypt('asdqwezxc'),
            'remember_token' => str_random(100),
        ]);

//        for ($i = 0; $i <= 19999999; $i++) {
//            $kode = \App\Model\sideGender::inRandomOrder()->first();
//            $status = \App\Model\sideStatusUser::inRandomOrder()->first();
//            \App\User::create([
//                'name' => $faker->unique()->name,
//                'url' => 'images/img_unvailable.png',
//                'email' => $faker->unique()->safeEmail,
//                'phone' => $faker->unique()->phoneNumber,
//                'address' => $faker->unique()->address,
//                'ni' => $faker->unique()->numerify($string = '1########'),
//                'gender_id' => $kode->id,
//                'status_id' => $status->id,
//                'code_status' => bcrypt(true),
//                'born_place' => $faker->city,
//                'dob' => $faker->date('Y-m-d'),
//                'password' => bcrypt('secret'),
//                'remember_token' => str_random(100)
//            ]);
//        }


    }
}
