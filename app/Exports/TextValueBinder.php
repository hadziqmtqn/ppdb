<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\IValueBinder;
use PhpOffice\PhpSpreadsheet\Exception;

class TextValueBinder extends DefaultValueBinder implements IValueBinder
{
    /**
     * @throws Exception
     */
    public function bindValue(Cell $cell, $value): bool
    {
        // Jika nilainya adalah numerik dan panjangnya lebih dari 11 karakter, ubah menjadi string
        if (is_numeric($value) && strlen((string) $value) > 8) {
            $cell->setValueExplicit($value);
            return true;
        }

        // Gunakan perilaku default untuk nilai lainnya
        return parent::bindValue($cell, $value);
    }
}
