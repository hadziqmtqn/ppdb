<?php

namespace Database\Seeders\References;

use App\Models\DetailMediaFile;
use App\Models\MediaFile;
use App\Models\RegistrationPath;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class MediaFileSeeder extends Seeder
{
    public function run(): void
    {
        $rows = json_decode(File::get(database_path('import/media-file.json')), true);

        foreach ($rows as $row) {
            $mediaFile = new MediaFile();
            $mediaFile->name = $row['name'];
            $mediaFile->save();

            if ($row['detail_media_files']) {
                foreach ($row['detail_media_files'] as $detail_media_file) {
                    $detailMediaFile = new DetailMediaFile();
                    $detailMediaFile->media_file_id = $mediaFile->id;
                    $detailMediaFile->educational_institution_id = $detail_media_file['educational_institution_id'];
                    $detailMediaFile->registration_path_id = RegistrationPath::where([
                        'educational_institution_id' => $detail_media_file['educational_institution_id'],
                        'code' => $detail_media_file['registration_path_code']
                    ])->first()->id ?? null;
                    $detailMediaFile->save();
                }
            }
        }
    }
}
