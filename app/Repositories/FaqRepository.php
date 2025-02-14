<?php

namespace App\Repositories;

use App\Models\Faq;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class FaqRepository
{
    use ApiResponse;

    protected Faq $faq;

    public function __construct(Faq $faq)
    {
        $this->faq = $faq;
    }

    public function getFaqs($request): JsonResponse
    {
        try {
            $faqs = $this->faq->filterData($request)
                ->get();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Get data error', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Get data success', $faqs->map(function (Faq $faq) {
            return collect([
                'title' => $faq->title,
                'description' => $faq->description
            ]);
        }), null, Response::HTTP_OK);
    }
}
