<?php

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\DeclaredPDO\photoUser as checkGender;

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
            'url' => 'storage/user-photos/fahmi.jpg',
            'gender_id' => \App\Model\sideGender::where('en','Male')->first()->id,
            'code_status' => bcrypt(true),
            'status_id' => \App\Model\sideStatusUser::where('eng','Admin')->first()->id,
            'born_place' => $faker->city,
            'dob' => $faker->unique()->date('Y-m-d'),
            'password' => bcrypt('asdqwezxc'),
            'remember_token' => str_random(100),
        ]);

//                   for ($i=0;$i<=19999999;$i++){
//               $kode=rand(1,2);
//               $status=rand(1,3);
//               $reli=UserSeeder::religion[rand(0,1)];
//               $chek=checkGender::check($kode);
//               \App\User::create([
//                   'name' => $faker->unique()->name,
//                   'email' => $faker->unique()->safeEmail,
//                   'phone' => $faker->unique()->phoneNumber,
//                   'address' => $faker->unique()->address,
//                   'ni' => $faker->unique()->numerify($string = '1########'),
//                   'gender' => $kode,
//                   'url' => $chek ,
//                   'religion'=>$reli,
//                   'status' =>'1',
//                   'status_id' => $status,
//                   'born_place' => $faker->city,
//                   'dob' => $faker->unique()->date('Y-m-d'),
//                   'password' => bcrypt('secret'),
//                   'remember_token' => str_random(100),
//                   'verifyToken' => str_random(255),
//               ]);
//           }


    }
}
