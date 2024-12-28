<?php

namespace Database\Seeders\Auth;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(base_path('database/import/permissions.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            Permission::create([
                'slug' => Str::uuid()->toString(),
                'name' => $row['name'],
                'category' => $row['category'],
            ]);
        }
    }
}
