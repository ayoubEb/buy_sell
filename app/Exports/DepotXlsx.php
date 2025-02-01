<?php

namespace App\Exports;
use App\Models\Depot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DepotXlsx implements FromCollection ,  WithHeadings , WithMapping , WithStyles , ShouldAutoSize , WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Depot::select("id","num_depot","adresse","quantite","disponible","entre","statut","sortie","id")->get();
    }


    public function headings(): array
    {
      return [
        Str::upper('#id'),
        Str::upper('numéro'),
        Str::upper('adresse'),
        Str::upper('quantite'),
        Str::upper('disponible'),
        Str::upper('entre'),
        Str::upper('sortie'),
        Str::upper('statut'),
      ];
    }

    public function map($depot): array
    {
      return [
        "#".$depot->id,
        $depot->num_depot,
        $depot->adresse,
        $depot->quantite,
        $depot->disponible,
        $depot->entre,
        $depot->sortie,
        $depot->statut == 1 ? 'active' : 'inactive',
      ];
    }
    public function styles(Worksheet $sheet)
    {
      $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
      $sheet->getStyle('A1:G1')->applyFromArray([
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
      $sheet->getStyle('A:G')->applyFromArray([
        'alignment' => [
          'vertical' => Alignment::VERTICAL_CENTER,
        ],
      ]);
      $sheet->getStyle('C:G')->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::VERTICAL_CENTER,
        ],
      ]);
    }
}
