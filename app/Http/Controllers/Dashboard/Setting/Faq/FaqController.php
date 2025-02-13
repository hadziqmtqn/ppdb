<?php

namespace App\Http\Controllers\Dashboard\Setting\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Traits\ApiResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class FaqController extends Controller implements HasMiddleware
{
    use ApiResponse;

    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('faq-read'), only: ['index', 'datatable', 'show']),
            new Middleware(PermissionMiddleware::using('faq-write'), only: ['store', 'update']),
            new Middleware(PermissionMiddleware::using('faq-delete'), only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $title = 'FAQ';
        $faqCategories = $this->getFaqCategories();

        return \view('dashboard.settings.faq.faq.index', compact('title', 'faqCategories'));
    }

    public function getFaqCategories()
    {
        return FaqCategory::select(['id', 'name'])
            ->get();
    }

    public function store(FaqRequest $request)
    {
        return Faq::create($request->validated());
    }

    public function show(Faq $faq)
    {
        return $faq;
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        $faq->update($request->validated());

        return $faq;
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();

        return response()->json();
    }
}
