<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $application = new Application();
        $application->name = 'Sistem Penerimaan Murid Baru';
        $application->foundation = 'Nusantara Education Foundation';
        $application->description = 'Situs ini dipersiapkan sebagai pusat informasi dan pengolahan seleksi data siswa peserta Tahun Pelajaran secara online dan realtime.';
        $application->website = 'https://ppdb.bkn.my.id';
        $application->main_website = 'https://bkn.my.id';
        $application->register_verification = true;
        $application->notification_method = 'email';
        $application->save();
    }
}
