<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TvaExample implements FromArray, WithHeadings, WithStyles , ShouldAutoSize
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
          Str::upper("nom"),
          Str::upper("valeur"),
          Str::upper("Description"),
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
    $sheet->getStyle('B')->applyFromArray([
      'alignment' => [
          'horizontal' => Alignment::VERTICAL_CENTER,
      ],

   ]);
  }
}
