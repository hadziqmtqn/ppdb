<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait HandlesBase64Images
{
    public function processBase64Images(string $content, string $directory): string
    {
        // Mencari dan memproses semua gambar base64 di dalam konten
        preg_match_all('/<img src="data:image\/(jpeg|png);base64,([^"]+)"/', $content, $matches);

        foreach ($matches[0] as $index => $imgTag) {
            $extension = $matches[1][$index];
            $base64Image = $matches[2][$index];

            // Mendekode base64 menjadi file gambar
            $image = base64_decode($base64Image);
            $imageName = uniqid() . '.' . $extension;
            $imagePath = $directory . '/' . $imageName;

            // Menyimpan gambar ke storage S3
            Storage::disk('s3')->put($imagePath, $image);

            // Mengatur visibilitas gambar menjadi publik
            Storage::disk('s3')->setVisibility($imagePath, 'public');

            // Menggantikan base64 dengan URL gambar
            $url = Storage::disk('s3')->url($imagePath);

            $content = str_replace($imgTag, '<img src="' . $url . '"', $content);
        }

        return $content;
    }

    public function deleteDirectory(string $directory): void
    {
        // Menghapus seluruh direktori beserta file di dalamnya
        Storage::disk('s3')->deleteDirectory($directory);
    }
}