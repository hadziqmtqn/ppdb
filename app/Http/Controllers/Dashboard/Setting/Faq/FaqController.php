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
use Symfony\Component\HttpFoundation\Response;
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
                    ->with('educationalInstitution:id,name', 'faqCategory:id,name')
                    ->orderByDesc('created_at');

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
                        $btn = '<a href="'. route('faq.show', $row->slug) .'" class="btn btn-icon btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a> ';
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
        try {
            $faq = new Faq();
            $faq->faq_category_id = $request->input('faq_category_id');
            $faq->educational_institution_id = $request->input('educational_institution_id');
            $faq->title = $request->input('title');
            $faq->description = $request->input('description');
            $faq->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function show(Faq $faq): View
    {
        $title = 'FAQ';
        $faq->load('faqCategory:id,name', 'educationalInstitution:id,name');
        $faqCategories = $this->getFaqCategories();

        return \view('dashboard.settings.faq.faq.show', compact('title', 'faq', 'faqCategories'));
    }

    public function update(FaqRequest $request, Faq $faq)
    {
        try {
            $faq->faq_category_id = $request->input('faq_category_id');
            $faq->educational_institution_id = $request->input('educational_institution_id');
            $faq->title = $request->input('title');
            $faq->description = $request->input('description');
            $faq->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }

    public function destroy(Faq $faq): JsonResponse
    {
        try {
            $faq->delete();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return $this->apiResponse('Data gagal dihapus!', null, null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->apiResponse('Data berhasil dihapus', null, null, Response::HTTP_OK);
    }
}
