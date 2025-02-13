<?php

namespace App\Http\Controllers\Dashboard\Setting\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqRequest;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        return Faq::all();
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
