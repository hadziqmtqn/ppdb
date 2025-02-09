<?php

namespace App\Repositories;

use App\Models\Application;
use App\Traits\FormatsFileSize;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ApplicationRepository
{
    use FormatsFileSize;

    protected Application $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getApplication(): Collection
    {
        $application = $this->application
            ->firstOrFail();

        return collect([
            'slug' => $application->slug,
            'name' => $application->name,
            'description' => $application->description,
            'website' => $application->website,
            'mainWebsite' => $application->main_website,
            'registerVerification' => $application->register_verification,
            'notificationMethod' => $application->notification_method,
            'logo' => $application->hasMedia('logo') ? $application->getFirstTemporaryUrl(Carbon::now()->addMinutes(5),'logo') : asset('assets/sekolah.png'),
        ]);
    }

    public function getAssets(Application $application): Collection
    {
        $collection = collect();
        foreach (collect([
            [
                'name' => 'login',
                'note' => [
                    '- Ukuran maksimal 1MB'
                ]
            ],
            [
                'name' => 'carousel',
                'note' => [
                    '- Ukuran maksimal 1Mb',
                    '- File disarankan berdimensi 1000x500 px'
                ]
            ]
        ]) as $asset) {
            $collection[] = collect([
                'asset' => $asset['name'],
                'notes' => $asset['note'],
                'media' => $application->getMedia($asset['name'])->map(function (Media $media) {
                    return [
                        'fileId' => $media->id,
                        'fileName' => $media->file_name,
                        'fileUrl' => $media->getTemporaryUrl(Carbon::now()->addDay()),
                        'fileSize' => $this->formatSizeUnits($media->size)
                    ];
                })
            ]);
        }

        return $collection;
    }
}
