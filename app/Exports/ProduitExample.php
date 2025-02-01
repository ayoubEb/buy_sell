<?php

namespace App\Exports;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProduitExample implements FromArray, WithHeadings , WithStyles , ShouldAutoSize
{
  protected $data;
  public function __construct(array $data)
  {
      $this->data = $data;
  }
  /**
  * @return \Illuminate\Support\Collection
  */
  public function array(): array
  {
      return $this->data;
  }
  public function headings(): array
  {
      return [
          Str::upper('Designation'),
          Str::upper('Description'),
          Str::upper('Prix Achat'),
          Str::upper('Prix Vente'),
          Str::upper('Prix Revient'),
          Str::upper('Quantite'),
      ];
  }

  public function styles(Worksheet $sheet)
  {
    // Alternatively, set default row height
    $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
    $sheet->getStyle('A1:K1')->applyFromArray([
      'font' => [
          'bold' => true,
          'size' => 10,
      ],

      'fill' => [
          'fillType' => Fill::FILL_SOLID,
          'startColor' => [
              'argb' => 'FFDDDDDD', // Light gray
          ],
      ],
  ]);
    $sheet->getStyle('A:K')->applyFromArray([
      'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
  ]);
  return [];
  }
}
