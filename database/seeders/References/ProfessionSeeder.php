<?php

namespace Database\Seeders\References;

use App\Models\Profession;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Tidak Bekerja/Ibu Rumah Tangga',
            'Petani',
            'TNI/Polisi',
            'Wiraswasta',
            'Pengusaha',
            'Pedagang',
            'Dokter/Bidan/Perawat',
            'Guru/Dosen',
            'PNS',
            'Pegawai Swasta',
            'Nelayan',
            'Sopir'
                 ] as $item) {
            $profession = new Profession();
            $profession->name = $item;
            $profession->save();
        }
    }
}
