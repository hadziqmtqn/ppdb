<?php

namespace Database\Seeders\References;

use App\Models\Transportation;
use Illuminate\Database\Seeder;

class TransportationSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Jalan kaki',
            'Sepeda',
            'Sepeda Motor',
            'Mobil Pribadi',
            'Antar Jemput Sekolah',
            'Angkatan Umum',
            'Perahu/Sampan',
            'Lainnya'
             ] as $item) {
            $transportation = new Transportation();
            $transportation->name = $item;
            $transportation->save();
        }
    }
}
