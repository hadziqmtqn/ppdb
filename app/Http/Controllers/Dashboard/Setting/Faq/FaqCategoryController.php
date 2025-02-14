<?php

namespace App\Http\Controllers\Dashboard\Setting\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqCategoryRequest;
use App\Models\EducationalInstitution;
use App\Models\FaqCategory;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FaqCategoryController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('faq-category-read'), only: ['index', 'datatable']),
            new Middleware(PermissionMiddleware::using('faq-category-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('faq-category-delete'), only: ['destroy'])
        ];
    }

    public function index(): View
    {
        $title = 'FAQ';
        $educationalInstitutions = EducationalInstitution::select(['id', 'name'])
            ->get();
        $faqCategories = FaqCategory::get()
            ->map(function (FaqCategory $faqCategory) {
                $qualification = json_decode($faqCategory->qualification, true);

                if (!is_array($qualification)) $qualification = [];

                return collect([
                    'slug' => $faqCategory->slug,
                    'name' => $faqCategory->name,
                    'qualification' => $qualification
                ]);
            });

        return \view('dashboard.settings.faq.faq-category.index', compact('title', 'educationalInstitutions', 'faqCategories'));
    }

    public function store(FaqCategoryRequest $request)
    {
        try {
            $slugs = $request->input('slugs', []);
            $names = $request->input('name', []);
            $qualifications = $request->input('qualification', []);

            DB::beginTransaction();
            foreach ($slugs as $key => $slug) {
                $faqCategory = FaqCategory::filterBySlug($slug)
                    ->firstOrFail();
                $faqCategory->name = $names[$key];
                // Set default qualification if not present
                if (!isset($qualifications[$key])) {
                    $qualifications[$key] = []; // Set default value here if needed
                }
                $faqCategory->qualification = json_encode(array_map('intval', $qualifications[$key]));
                $faqCategory->save();
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function destroy(FaqCategory $faqCategory): JsonResponse
    {
        try {
            $faqCategory->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus!', null, null, Response::HTTP_OK);
    }
}
