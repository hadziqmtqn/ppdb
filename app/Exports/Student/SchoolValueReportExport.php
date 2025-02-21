<?php

namespace App\Exports\Student;

use App\Models\EducationalGroup;
use App\Models\EducationalInstitution;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchoolValueReportExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    use Exportable;

    protected Request $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    private function educationalInstitution(): ?EducationalInstitution
    {
        return EducationalInstitution::find($this->request->input('educational_institution_id'));
    }

    private function educationalGroup(): ?EducationalGroup
    {
        return EducationalGroup::find($this->request->input('educational_group_id'));
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return User::with('student.educationalInstitution', 'previousSchool')
            ->whereHas('student', fn($query) => $query->where('educational_institution_id', $this->educationalInstitution()->id))
            ->whereHas('previousSchool', fn($query) => $query->where('educational_group_id', $this->educationalGroup()->id))
            ->whereHas('schoolReports')
            ->get()
            ->map(function (User $user, $index) {
                return collect([
                    $index + 1,
                    $user->name,
                    optional(optional($user->student)->educationalInstitution)->name,
                    optional($user->previousSchool)->school_name
                ]);
            });
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'No',
            'Nama',
            'Lembaga',
            'Asal Sekolah'
        ];
    }
}
