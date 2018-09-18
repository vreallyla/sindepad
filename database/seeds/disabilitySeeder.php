<?php

use Illuminate\Database\Seeder;

class disabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Model\mstDisability::insert([
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Tunanetra',
                    'en' => 'Blind',
                    'detail' => 'Tunanetra adalahhambatan dalam indra penglihatan.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Tunarungu',
                    'en' => 'Deaf',
                    'detail' => 'Tunarungu adalah kondisi terganggunya fungsi pendengaran seseorang yang bisa berlangsung hanya sementara atau permanen.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Tunawicara',
                    'en' => 'Speech Impaired',
                    'detail' => 'Tunawicara memiliki ketidakmampuan untuk mengkomunikasikan gagasannya kepada pendengar (orang lain) dengan menggunakan organ bicaranya.',
                    'created_at'=>now(),
                    'updated_at'=>now(),

                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Tunagrahita',
                    'en' => 'Mentally Disabled',
                    'detail' => 'Anak tunagrahita adalah anak yang mengalami hambatan fungsi kecerdasan intelektual dan adaptasi sosial yang terjadi pada masa perkembangannya. ',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Tunadaksa',
                    'en' => 'Quadriplegic',
                    'detail' => 'anak tunadaksa adalah anak yang mengalami kerusakan atau kelainan pada tulang, otot, dan sendi dalam fungsinya secara normal sehingga mengakibatkan gangguan pada komunikasi, bersosialisasi, dan berkembang bagi dirinya.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Tunalaras',
                    'en' => 'Unsociable',
                    'detail' => 'Anak tunalaras dapat diklasifikasikan menjadi anak yang mengalami kesukaran dalam menyesuaikan diri dengan lingkungan sosial dan anak yang mengalami gangguan emosi.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Kesulitan belajar',
                    'en' => 'learning disability',
                    'detail' => 'Kesulitan belajar adalah masalah yang memengaruhi kemampuan otak untuk menerima, mengolah, menganalisis, atau menyimpan informasi, sehingga memperlambat anak dalam perkembangan akademik.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Autis',
                    'en' => 'Autism',
                    'detail' => 'Autisme berkaitan dengan gangguan kemampuan sosial yang penderitanya berinteraksi berbeda dengan orang pada umumnya.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Gangguan Motorik',
                    'en' => 'Motoric Disoders',
                    'detail' => 'Gangguan motorik adalah anak yang menggalami kelainan atau cacat yang menetap pada alat gerak ( tulang, sendi, otot ) sedemikian rupa sehingga memerlukan peleyanan pendidikan khusus jika mengalami gangguan gerakan karena kelayuhan pada fungsi otak.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Korban Obat Terlarang',
                    'en' => 'Drug Victim',
                    'detail' => 'anak yang telah terjangkit obat-obat terlarang dan perlu dilakukan penanganan khusus',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ],
                [
                    'id' => (string)\Webpatser\Uuid\Uuid::generate(4),
                    'name' => 'Kelainan Lainnya',
                    'en' => 'Other Disoders',
                    'detail' => 'Jika kebutuhan anak anda tidak ada anda dapat memilih ini.',
                    'created_at'=>now(),
                    'updated_at'=>now(),
                ]
            ]
        );
    }
}
