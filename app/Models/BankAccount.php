<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class BankAccount extends Model
{
    protected $fillable = [
        'slug',
        'payment_channel_id',
        'account_name',
        'account_number',
        'educational_institution_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'slug' => 'string',
            'is_active' => 'boolean',
        ];
    }

    protected static function boot(): void
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::creating(function (BankAccount $bankAccount) {
            $bankAccount->slug = Str::uuid()->toString();
        });

        static::created(function (BankAccount $bankAccount) {
            if ($bankAccount->is_active) {
                self::where('id', '!=', $bankAccount->id)
                    ->where('payment_channel_id', $bankAccount->payment_channel_id)
                    ->update(['is_active' => false]);
            }
        });

        static::updated(function (BankAccount $bankAccount) {
            if ($bankAccount->is_active) {
                self::where('id', '!=', $bankAccount->id)
                    ->where('payment_channel_id', $bankAccount->payment_channel_id)
                    ->update(['is_active' => false]);
            }
        });
    }

    public function educationalInstitution(): BelongsTo
    {
        return $this->belongsTo(EducationalInstitution::class);
    }

    public function paymentChannel(): BelongsTo
    {
        return $this->belongsTo(PaymentChannel::class);
    }

    // TODO Scope
    public function scopeFilterByEducationalInstitution(Builder $query): Builder
    {
        $auth = auth()->user();

        return $query->when(!$auth->hasRole('super-admin'), fn($query) => $query->where('educational_institution_id'), optional(optional($auth)->admin)->educational_institution_id);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeEducationalInstitutionId(Builder $query, $educationalInstitutionId): Builder
    {
        return $query->where('educational_institution_id', $educationalInstitutionId);
    }

    public function scopeSearch(Builder $query, $request): Builder
    {
        $search = $request['search'] ?? null;

        return $query->when($search, function ($query) use ($search) {
            $query->where('account_name', 'like', '%' . $search . '%');
        });
    }
}
