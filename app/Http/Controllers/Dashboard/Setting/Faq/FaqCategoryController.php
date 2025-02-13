<?php

namespace App\Http\Controllers\Dashboard\Setting\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqCategoryRequest;
use App\Models\FaqCategory;

class FaqCategoryController extends Controller
{
    public function index()
    {
        return FaqCategory::all();
    }

    public function store(FaqCategoryRequest $request)
    {
        return FaqCategory::create($request->validated());
    }

    public function show(FaqCategory $faqCategory)
    {
        return $faqCategory;
    }

    public function update(FaqCategoryRequest $request, FaqCategory $faqCategory)
    {
        $faqCategory->update($request->validated());

        return $faqCategory;
    }

    public function destroy(FaqCategory $faqCategory)
    {
        $faqCategory->delete();

        return response()->json();
    }
}
