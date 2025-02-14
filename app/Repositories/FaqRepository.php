<?php

namespace App\Repositories;

use App\Models\Faq;
use App\Models\FaqCategory;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FaqRepository
{
    use ApiResponse;

    protected FaqCategory $faqCategory;
    protected Faq $faq;

    public function __construct(FaqCategory $faqCategory, Faq $faq)
    {
        $this->faqCategory = $faqCategory;
        $this->faq = $faq;
    }

    public function getFaqCategories($request): JsonResponse
    {
        $educationalInstitutionId = $request['educational_institution_id'];

        try {
            $faqCategories = $this->faqCategory
                ->whereHas('faqs')
                ->get()
                ->filter(function (FaqCategory $faqCategory) use ($educationalInstitutionId) {
                    $qualifications = json_decode($faqCategory->qualification, true);
                    return in_array($educationalInstitutionId, $qualifications);
                });
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Get data error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $faqCategories->map(function (FaqCategory $faqCategory) {
            return collect([
                'id' => $faqCategory->id,
                'name' => $faqCategory->name
            ]);
        }), null, Response::HTTP_OK);
    }

    public function getFaqs($request): JsonResponse
    {
        try {
            $faqs = $this->faq
                ->with('faqCategory:id,name', 'educationalInstitution:id,name')
                ->filterData($request)
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Get data error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $faqs->map(function (Faq $faq) {
            return collect([
                'faqCategory' => optional($faq->faqCategory)->name,
                'educationalInstitution' => optional($faq->educationalInstitution)->name,
                'title' => $faq->title,
                'description' => $faq->description
            ]);
        }), null, Response::HTTP_OK);
    }
}
