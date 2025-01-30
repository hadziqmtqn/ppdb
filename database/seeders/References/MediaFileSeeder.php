<?php

namespace Database\Seeders\References;

use App\Models\MediaFile;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\InvalidArgument;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class MediaFileSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws InvalidArgument
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/media-file.csv'))
            ->setHeaderOffset(0)
            ->setDelimiter(';');

        foreach ($rows as $row) {
            $file = new MediaFile();
            $file->name = $row['name'];
            $file->category = $row['category'];
            $file->educational_institutions = $row['category'] == 'unit_tertentu' && !empty($row['educational_institutions']) ? $row['educational_institutions'] : null;
            $file->save();
        }
    }
}
