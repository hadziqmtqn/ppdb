<?php

namespace App\Exports\Student;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class StudentReportExcel implements FromCollection, ShouldAutoSize
{
    use Exportable;

    protected mixed $request;

    /**
     * @param mixed $request
     */
    public function __construct(mixed $request)
    {
        $this->request = $request;
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return User::filterStudentDatatable($this->request)
            ->get()
            ->map(function (User $user) {
                return collect([
                    $user->name
                ]);
            });
    }
}
