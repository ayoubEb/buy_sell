<?php

namespace App\Exports;

use App\Models\Categorie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CategorieXlsx implements FromCollection , WithHeadings , WithStyles , ShouldAutoSize , WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Categorie::select("id","nom","description")->get();
    }


    public function headings(): array
    {
        return [
            Str::upper("#id"),
            Str::upper("nom"),
            Str::upper("description"),
        ];
    }

    public function map($categorie): array
    {
      return [
        "#" . $categorie->id,
        $categorie->nom ?? 'N/A',
        $categorie->description ?? 'N/A',
      ];
    }

    public function styles(Worksheet $sheet)
    {
      $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
      $sheet->getStyle('A1:C1')->applyFromArray([
        'font' => [
            'bold' => true,
            'size' => 10,
        ],
        'alignment' => [
            'vertical' => Alignment::VERTICAL_CENTER,
        ],
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => [
                'argb' => 'FFDDDDDD', // Light gray
            ],
        ],
    ]);
      $sheet->getStyle('A:C')->applyFromArray([
        'alignment' => [
            'vertical' => Alignment::VERTICAL_CENTER,
        ],

    ]);

    return [];
  }
}
