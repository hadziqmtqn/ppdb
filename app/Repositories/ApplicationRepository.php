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
            'foundation' => $application->foundation,
            'description' => $application->description,
            'website' => $application->website,
            'mainWebsite' => $application->main_website,
            'registerVerification' => $application->register_verification,
            'notificationMethod' => $application->notification_method,
            'logo' => $application->hasMedia('logo') ? $application->getFirstTemporaryUrl(Carbon::now()->addMinutes(5),'logo') : asset('assets/sekolah.png'),
            'loginAssets' => $application->hasMedia('login') ? $application->getFirstTemporaryUrl(Carbon::now()->addMinutes(10),'login') : asset('materialize/assets/img/illustrations/auth-login-illustration-light.png'),
            'frontHeaderAssets' => $application->hasMedia('front_header') ? $application->getFirstTemporaryUrl(Carbon::now()->addMinutes(10),'front_header') : asset('assets/jane.jpg'),
            'carouselAssets' => $application->getMedia('carousel')->map(function (Media $media) {
                return [
                    'fileUrl' => $media->getTemporaryUrl(Carbon::now()->addDay())
                ];
            })
        ]);
    }

    private function collections(): Collection
    {
        return collect([
            [
                'name' => 'login',
                'note' => [
                    '- Ukuran maksimal 500KB'
                ]
            ],
            [
                'name' => 'front_header',
                'note' => [
                    '- Ukuran maksimal 500KB',
                    '- Background halaman beranda teratas'
                ]
            ],
            [
                'name' => 'carousel',
                'note' => [
                    '- Ukuran maksimal 500KB',
                    '- File disarankan berdimensi 1000x500 px'
                ]
            ]
        ]);
    }

    public function getAssets(Application $application): Collection
    {
        $collection = collect();
        foreach ($this->collections() as $asset) {
            $collection[] = collect([
                'asset' => $asset['name'],
                'notes' => $asset['note'],
                'media' => $application->getMedia($asset['name'])->map(function (Media $media) {
                    return [
                        'fileId' => $media->id,
                        'fileName' => $media->file_name,
                        'fileUrl' => $media->getTemporaryUrl(Carbon::now()->addHour()),
                        'fileSize' => $this->formatSizeUnits($media->size)
                    ];
                })
            ]);
        }

        return $collection;
    }
}
