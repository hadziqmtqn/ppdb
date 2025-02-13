<?php

namespace App\Http\Controllers\Dashboard\Setting\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Faq\FaqRequest;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

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

    public function datatable(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            if ($request->ajax()) {
                $data = Faq::query()
                    ->with('educationalInstitution:id,name', 'faqCategory:id,name');

                return DataTables::eloquent($data)
                    ->addIndexColumn()
                    ->filter(function ($instance) use ($request) {
                        $search = $request->get('search');

                        $instance->when($search, function ($query) use ($search) {
                            $query->whereAny(['title', 'description'], 'LIKE', '%' . $search . '%');
                        });
                    })
                    ->addColumn('faqCategory', fn($row) => optional($row->faqCategory)->name)
                    ->addColumn('educationalInstitution', fn($row) => optional($row->educationalInstitution)->name ?? 'Umum')
                    ->addColumn('description', fn($row) => Str::limit(strip_tags($row->description), 80))
                    ->addColumn('action', function ($row) {
                        $btn = '<a href="'. route('faq.show', $row->slug) .'" class="btn btn-icon btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEdit"><i class="mdi mdi-pencil"></i></a> ';
                        $btn .= '<button href="javascript:void(0)" data-slug="'. $row->slug .'" class="delete btn btn-icon btn-sm btn-danger"><i class="mdi mdi-delete"></i></button>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'is_active'])
                    ->make();
            }
        }catch (Exception $exception) {
            Log::error($exception->getMessage());
        }

        return response()->json(true);
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

    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();

        return response()->json();
    }
}
