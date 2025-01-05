<?php

namespace Database\Seeders\Setting;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Membaca konten dari file JSON
        $data = json_decode(File::get(database_path('import/menu.json')), true);

        // Memproses setiap item dalam file JSON
        foreach ($data as $key => $row) {
            $menu = new Menu();
            $menu->serial_number = $key + 1;
            $menu->name = $row['name'];
            $menu->type = $row['type'];
            $menu->visibility = json_encode($row['visibility']);
            $menu->url = $row['url'];
            $menu->icon = !empty($row['icon']) ? $row['icon'] : null;
            $menu->save();

            // Memproses sub_menu jika ada
            if (!empty($row['sub_menu'])) {
                foreach ($row['sub_menu'] as $subKey => $subRow) {
                    $subMenu = new Menu();
                    $subMenu->serial_number = $subKey + 1;
                    $subMenu->name = $subRow['name'];
                    $subMenu->type = $subRow['type'];
                    $subMenu->main_menu = $menu->id; // Menggunakan ID menu utama yang baru disimpan
                    $subMenu->visibility = json_encode($subRow['visibility']);
                    $subMenu->url = $subRow['url'];
                    $subMenu->icon = !empty($subRow['icon']) ? $subRow['icon'] : null;
                    $subMenu->save();
                }
            }
        }
    }
}
