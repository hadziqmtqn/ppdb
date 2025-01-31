<?php

namespace App\Repositories;

use App\Models\MediaFile;

class MediaFileRepoitory
{
    protected MediaFile $mediaFile;

    public function __construct(MediaFile $mediaFile)
    {
        $this->mediaFile = $mediaFile;
    }

    public function getFiles($educationalInstitutionId): array
    {
        $mediaFiles = $this->mediaFile->query()
            ->select(['file_code', 'name', 'educational_institutions', 'category'])
            ->get()
            ->filter(function ($uploadFileCategory) use ($educationalInstitutionId) {
                // Konversi string JSON ke array, jika gagal jadikan array kosong
                $institutions = json_decode($uploadFileCategory->educational_institutions, true) ?? [];

                // Memeriksa apakah ID ada dalam `educational_institutions` atau jika category adalah 'semua_unit'
                if (empty($institutions) && $uploadFileCategory->category === 'semua_unit') {
                    return true; // Jika educational_institutions kosong, pastikan kita ambil berdasarkan kategori 'semua_unit'
                }

                // Memeriksa apakah ID ada dalam `educational_institutions`
                return in_array($educationalInstitutionId, $institutions);
            });

        $file = [];
        foreach ($mediaFiles as $uploadFileCategory) {
            $file[$uploadFileCategory->file_code] = $uploadFileCategory->name;
        }

        return $file;
    }
}
