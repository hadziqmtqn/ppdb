<?php

namespace App\Services;

use App\Models\PaymentChannel;
use Xendit\Configuration;
use Xendit\Invoice\CreateInvoiceRequest;
use Xendit\Invoice\Invoice;
use Xendit\Invoice\InvoiceApi;
use Xendit\XenditSdkException;

class XenditService
{
    public function __construct()
    {
        Configuration::setXenditKey(config('xendit.api_key'));
    }

    /**
     * @throws XenditSdkException
     */
    public function createInvoice(array $request): Invoice
    {
        return (new InvoiceApi())->createInvoice(new CreateInvoiceRequest([
            'external_id' => $request['paymentCode'],
            'amount' => $request['amount'],
            'payer_email' => $request['payerEmail'],
            'description' => $request['description'],
            'invoice_duration' => $request['invoiceDuration'],
            'payment_methods' => PaymentChannel::active()
                ->pluck('code')
                ->toArray()
        ]));
    }
}
