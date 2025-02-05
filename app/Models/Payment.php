<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
    protected $fillable = [
        'slug',
        'serial_number',
        'code',
        'payment_transaction_id',
        'amount',
        'link_checkout',
        'status',
        'payment_method',
        'payment_channel',
        'bank_account_id',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (Payment $payment) {
            $payment->slug = Str::uuid()->toString();
            $payment->serial_number = self::max('serial_number') + 1;
            $payment->code = 'INV' . Str::padLeft($payment->serial_number, 4, '0');
        });
    }
}
