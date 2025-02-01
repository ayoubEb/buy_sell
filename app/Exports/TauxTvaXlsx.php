<?php

namespace App\Exports;
use App\Models\TauxTva;
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

class TauxTvaXlsx implements FromCollection , WithHeadings , WithMapping , WithStyles , ShouldAutoSize , WithStrictNullComparison
{
 /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
      return TauxTva::select("id","nom","valeur","description")->get();
  }

  public function headings(): array
  {
    return [
      Str::upper('#id'),
      Str::upper('nom'),
      Str::upper('valeur'),
      Str::upper('description'),
    ];
  }

  public function map($tauxTva): array
  {
    return [
      "#".$tauxTva->id,
      $tauxTva->nom ?? 'N/A',
      ($tauxTva->valeur ?? 0)."%",
      $tauxTva->description ?? 'N/A',
    ];
  }
  public function styles(Worksheet $sheet)
  {
    $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
    $sheet->getStyle('A1:D1')->applyFromArray([
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
    $sheet->getStyle('A:D')->applyFromArray([
      'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
      ],
    ]);
    $sheet->getStyle('B')->applyFromArray([
      'alignment' => [
        'horizontal' => Alignment::VERTICAL_CENTER,
      ],
    ]);
  }
}
