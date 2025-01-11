<?php

namespace Database\Seeders\References;

use App\Models\Income;
use Illuminate\Database\Seeder;
use League\Csv\Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;

class IncomeSeeder extends Seeder
{
    /**
     * @throws UnavailableStream
     * @throws Exception
     */
    public function run(): void
    {
        $rows = Reader::createFromPath(database_path('import/income.csv'))
            ->setHeaderOffset(0);

        foreach ($rows as $row) {
            $income = new Income();
            $income->nominal = $row['nominal'];
            $income->save();
        }
    }
}
