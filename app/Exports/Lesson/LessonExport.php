<?php

namespace App\Exports\Lesson;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LessonExport implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle, WithEvents
{
    use Exportable;

    protected Collection $lessons;

    /**
     * @param Collection $lessons
     */
    public function __construct(Collection $lessons)
    {
        $this->lessons = $lessons;
    }

    public function title(): string
    {
        // TODO: Implement title() method.
        return 'Kode Mapel';
    }

    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return $this->lessons->map(function ($lesson, $index) {
            return [
                'No' => $index + 1,
                'Kode' => $lesson['lessonCode'],
                'Nama Mata Pelajaran' => $lesson['lessonName']
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode',
            'Nama Mata Pelajaran'
        ];
    }

    public function registerEvents(): array
    {
        // TODO: Implement registerEvents() method.
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastColumnIndex = $sheet->getHighestColumn();
                $lastColumn = Coordinate::columnIndexFromString($lastColumnIndex);
                $lastColumnToAdd = Coordinate::stringFromColumnIndex($lastColumn);
                $totalRows = $sheet->getHighestRow();
                $sheet->getParent()->getDefaultStyle()->getFont()->setName('Arial');
                $sheet->getParent()->getDefaultStyle()->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

                $sheet->getStyle('A1:' . $lastColumnToAdd . '1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1:' . $lastColumnToAdd . '1')
                    ->getFont()
                    ->setBold(true);

                // background header
                $sheet->getStyle('A1:' . $lastColumnIndex . '1')
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('86D293');
                // border header
                $sheet->getStyle('A1:' . $lastColumnIndex . $totalRows)
                    ->getBorders()
                    ->getAllBorders()
                    ->setBorderStyle('thin');
                // semua baris menggunakan format "text" secara default
                $sheet->getStyle('A1:' . $lastColumnIndex . $totalRows)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_TEXT);
            }
        ];
    }
}