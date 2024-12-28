<?php

namespace Database\Seeders\References;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class MenuSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(base_path('database/import/menu.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $menu = new Menu();
            $menu->name = $row['name'];
            $menu->type = $row['type'];
            $menu->main_menu = $row['main_menu'] ?? null;
            $menu->visibility = $row['visibility'];
            $menu->url = $row['url'];
            $menu->icon = $row['icon'] ?? null;
            $menu->save();
        }
    }
}
