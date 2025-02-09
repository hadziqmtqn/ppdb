<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ApplicationRequest;
use App\Http\Requests\Application\AssetsRequest;
use App\Models\Application;
use App\Repositories\ApplicationRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ApplicationController extends Controller implements HasMiddleware
{
    protected ApplicationRepository $applicationRepository;

    /**
     * @param ApplicationRepository $applicationRepository
     */
    public function __construct(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('application-read'), only: ['index', 'assets']),
            new Middleware(PermissionMiddleware::using('application-write'), only: ['store', 'saveAssets', 'deleteAssets']),
        ];
    }

    public function index(): View
    {
        $title = 'Aplikasi';

        return view('dashboard.application.index', compact('title'));
    }

    public function store(ApplicationRequest $request)
    {
        try {
            $application = Application::firstOrNew();
            $application->name = $request->input('name');
            $application->description = $request->input('description');
            $application->website = $request->input('website');
            $application->main_website = $request->input('main_website');
            $application->register_verification = $request->input('register_verification');
            $application->notification_method = $request->input('notification_method');
            $application->save();

            if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
                if ($application->hasMedia('logo')) {
                    $application->clearMediaCollection('logo');
                }

                $application->addMedia($request->file('logo'))->toMediaCollection('logo');
            }
        }catch (Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function assets(Application $application): View
    {
        $title = 'Aplikasi';
        $getAssets = $this->applicationRepository->getAssets($application);

        return \view('dashboard.application.assets', compact('title', 'application', 'getAssets'));
    }

    public function saveAssets(AssetsRequest $request, Application $application)
    {
        try {
            $files = $request->file('file', []);

            foreach ($files as $collectionKey => $file) {
                if ($file->isValid()) {
                    if ($collectionKey === 'login' && $application->hasMedia('login')) {
                        $application->clearMediaCollection('login');
                    }

                    $application->addMedia($file)
                        ->toMediaCollection($collectionKey);
                }
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Media gagal diupload!');
        }

        return redirect()->back()->with('success', 'Media berhasil diupload!');
    }

    public function deleteAssets(Request $request, Application $application)
    {
        try {
            $collections = $request->input('collection', []);

            foreach ($collections as $fileId => $collection) {
                $mediaItem = $application->getMedia($collection)->where('id', $fileId)
                    ->first();

                if ($mediaItem) {
                    $mediaItem->delete();
                }
            }
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Media gagal dihapus!');
        }

        return redirect()->back()->with('success', 'Media berhasil dihapus!');
    }
}
