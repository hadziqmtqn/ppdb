<?php

namespace App\Rules\Student\Payment;

use App\Models\User;
use App\Repositories\Student\Payment\CurrentBillRepository;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RegistrationFeeRule implements ValidationRule
{
    protected mixed $username;
    protected CurrentBillRepository $currentBillRepository;

    /**
     * Konstruktor untuk menerima username dan repository tagihan saat ini.
     *
     * @param mixed $username
     * @param CurrentBillRepository $currentBillRepository
     */
    public function __construct(mixed $username, CurrentBillRepository $currentBillRepository)
    {
        $this->username = $username;
        $this->currentBillRepository = $currentBillRepository;
    }

    /**
     * Metode validasi untuk memastikan biaya pendaftaran valid.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Ambil data user berdasarkan username dengan relasi student
        $user = User::with('student')
            ->whereHas('student')
            ->filterByUsername($this->username)
            ->first();

        if (!$user) {
            $fail('Siswa tidak ditemukan.');
            return;
        }

        // Ambil biaya pendaftaran yang sesuai dengan siswa
        $currentBills = $this->currentBillRepository->getRegistrationFee($user)->get();

        if ($currentBills->isEmpty()) {
            $fail('Tidak ada biaya pendaftaran yang tersedia untuk siswa ini.');
            return;
        }

        // Ambil semua ID biaya pendaftaran yang valid
        $validFeeIds = $currentBills->pluck('id')->toArray();

        dd($validFeeIds, $value);
        // Pastikan nilai yang dikirim adalah array
        if (!is_array($value)) {
            $value = [$value]; // Konversi ke array jika hanya satu nilai
        }

        // Cek apakah semua ID yang dikirim valid
        if (array_diff($value, $validFeeIds)) {
            $fail('Biaya pendaftaran tidak valid atau tidak terkait dengan siswa ini.');
            return;
        }

        // Pastikan bahwa biaya dengan status `siswa_belum_diterima` harus ada dalam input
        $mandatoryFees = $currentBills->where('registration_status', 'siswa_belum_diterima')->pluck('id')->toArray();

        if (!empty($mandatoryFees) && empty(array_intersect($mandatoryFees, $value))) {
            $fail('Biaya registrasi wajib dibayar.');
        }
    }
}
