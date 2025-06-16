<?php

namespace App\Imports;

use App\Models\Mongo\Record;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Illuminate\Support\Collection;

class ImportInstrument implements 
    ToCollection,
    WithHeadingRow,
    WithChunkReading,
    WithCustomCsvSettings,
    WithStartRow
{
    public function __construct()
    {
        HeadingRowFormatter::default('none'); // evita conversão para snake_case
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
        ];
    }

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        $bulk = [];

        foreach ($rows as $row) {
            $bulk[] = [
                'RptDt'         => isset($row['RptDt']) ? date('Y-m-d', strtotime($row['RptDt'])) : null,
                'TckrSymb'      => $row['TckrSymb'] ?? 'salvou',
                'MktNm'         => $row['MktNm'] ?? 'salvou',
                'SctyCtgyNm'    => $row['SctyCtgyNm'] ?? 'salvou',
                'ISIN'          => $row['ISIN'] ?? 'salvou',
                'CrpnNm'        => $row['CrpnNm'] ?? 'salvou',
            ];
        }

        Record::insert($bulk);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
