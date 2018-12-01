<?php

use Illuminate\Database\Seeder;

class noteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\sideNote::create([
            'detail'=>'<h4>Persyaratan Pendaftaran</h4>
        <ul>
            <li>
                Berhubung sebagian pembelajaran di Sanggar ABK berhubungan
                dengan ajaran Islam, setiap murid harus mengikut kegiatan tersebut.
            </li>
            <li>
                Sanggar ABK hanya menerima murid usia 8-15 tahun.
            </li>
            <li>
                Sanggar ABK hanya menerima murid dengan kebutuhan Grahita,
                Down Syndrome, Autis, dan Cerebral Palsy.
            </li>
        </ul>
        <h4>Biaya Pendaftaran</h4>
        <ul>
            <li>
                Uang Gedung: 5jt//anak
            </li>
            <li>
                Biaya Pendaftaran: 1jt/anak
            </li>
            <li>
                Biaya Bulanan: 2jt/anak
            </li>
            <li>
                <b>Total Pendaftaran Awal: 8jt/anak</b>
            </li>
        </ul>
        <h4>Apa yang didapat?</h4>
        <ul>
            <li>
                Seragam,Buku dan alat pendukung
            </li>
            <li>
                Pembelajaran <i>full day</i> dari senin - jum\'at.
            </li>
            <li>
                terapi visio, wicara, ocupasi, perilaku, dsb.
            </li>
        </ul>',
            'status'=>'Active'
        ]);
    }
}
