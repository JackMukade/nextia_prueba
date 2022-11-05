<?php
namespace App\Imports;

use App\Models\Bienes;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class ItemImport implements ToModel, WithStartRow, WithCustomCsvSettings {

    use Importable;

    public function model(array $row){

        return new Bienes([
            'idItem'        => $row[0],
            'articulo'      => $row[1],
            'descripcion'   => $row[2]
        ]);

    }

    public function startRow(): int { return 2; }

    public function getCsvSettings(): array { return ['input_encoding' => 'ISO-8859-1']; }

}
