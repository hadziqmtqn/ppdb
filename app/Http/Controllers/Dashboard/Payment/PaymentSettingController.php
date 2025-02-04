<?php

namespace App\Http\Controllers\Dashboard\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentMethod\PaymentSettingRequest;
use App\Models\PaymentSetting;
use Exception;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class PaymentSettingController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        // TODO: Implement middleware() method.
        return [
            new Middleware(PermissionMiddleware::using('payment-setting-read'), only: ['index']),
            new Middleware(PermissionMiddleware::using('payment-setting-write'), only: ['update'])
        ];
    }

    public function index(): View
    {
        $title = 'Pengaturan Pembayaran';
        $paymentSetting = PaymentSetting::firstOrFail();

        return \view('dashboard.payment.payment-setting.index', compact('title', 'paymentSetting'));
    }

    public function update(PaymentSettingRequest $request, PaymentSetting $paymentSetting)
    {
        try {
            $paymentSetting->payment_method = $request->input('payment_method');
            $paymentSetting->save();
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Data gagal disimpan!');
        }

        return redirect()->back()->with('success', 'Data berhasil disimpan!');
    }
}
