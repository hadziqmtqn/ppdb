<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use ReflectionClass;
use ReflectionException;

class ModelRepository
{
    public function __construct()
    {
    }

    /**
     * @throws ReflectionException
     */
    public function getAllModelsFromClassmap(): array
    {
        // Path ke folder Models
        $modelsPath = app_path('Models');

        // Muat semua file di direktori Models
        foreach (File::allFiles($modelsPath) as $file) {
            $class = 'App\\Models\\' . str_replace('.php', '', $file->getFilename());

            // Pastikan class ada sebelum ditambahkan
            if (class_exists($class)) {
                continue; // Class sudah ada
            }

            require_once $file->getPathname(); // Muat file PHP
        }

        // Ambil semua kelas yang telah dideklarasikan
        $models = [];
        $classes = get_declared_classes();

        foreach ($classes as $class) {
            if (is_subclass_of($class, Model::class) && !(new ReflectionClass($class))->isAbstract() && str_starts_with($class, 'App\Models\\')) {
                $models[] = $class;
            }
        }

        return $models;
    }
}
