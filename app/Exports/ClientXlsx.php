<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ClientXlsx implements FromCollection , WithHeadings , WithStyles , ShouldAutoSize , WithStrictNullComparison
{
  protected $clients;

    /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $clients = Client::select("identifiant","if_client","raison_sociale","adresse","ville","code_postal","ice","rc" , "telephone","activite" , "email" , "montant" , "payer" , "reste" ,"montant_devis")->get();
    return $this->clients = $clients;
  }


  public function headings(): array
  {
      return [
        Str::upper('Identifiant') ,
        Str::upper('if') ,
        Str::upper('Raison sociale') ,
        Str::upper('Adresse') ,
        Str::upper('Ville') ,
        Str::upper('Code postal') ,
        Str::upper('ICE') ,
        Str::upper('RC') ,
        Str::upper('Téléphone') ,
        Str::upper('activite') ,
        Str::upper('Email') ,
        Str::upper('Montant') ,
        Str::upper('Payer') ,
        Str::upper('Reste') ,
        Str::upper('Montant devis') ,
      ];
  }

  public function map($client): array
  {
    return [
      $client->identifiant ?? 'N/A',
      $client->if_client ?? 'N/A',
      $client->raison_sociale ?? 'N/A',
      $client->adresse ?? 'N/A',
      $client->ville ?? 'N/A',
      $client->code_postal ?? 'N/A',
      $client->ice ?? 'N/A',
      $client->rc ?? 'N/A',
      $client->telephone ?? 'N/A',
      $client->activite ?? 'N/A',
      $client->email ?? 'N/A',
      number_format($client->montant , 2 , "," , " ") ?? 0,
      number_format($client->payer , 2 , "," , " ") ?? 0,
      number_format($client->reste , 2 , "," , " ") ?? 0,
      number_format($client->montant_devis , 2 , "," , " ") ?? 0,
    ];
  }


  public function styles(Worksheet $sheet)
  {
    $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
    $sheet->getStyle('A1:O1')->applyFromArray([
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
    $sheet->getStyle('A:O')->applyFromArray([
      'alignment' => [
          'vertical' => Alignment::VERTICAL_CENTER,
      ],
      'font'=>[
        'name' => 'Cambria',
      ]
    ]);
    $sheet->getStyle('L:O')->applyFromArray([
      'alignment' => [
          'vertical' => Alignment::VERTICAL_CENTER,
          'horizontal' => Alignment::HORIZONTAL_CENTER,
      ],
    ]);

    // return [];
    foreach ($this->clients as $rowIndex => $stockDepot) {
      $excelRow = $rowIndex + 2; // Data starts at row 2 (row 1 is headers)

      $sheet->getStyle("M{$excelRow}")->applyFromArray([

        'font' => [
            'color' => [
              'argb'=>Color::COLOR_DARKGREEN  // Set font color to green
            ]
          ],
        ]);
        $sheet->getStyle("N{$excelRow}")->applyFromArray([

          'font' => [
            'color' => [
              'argb'=>Color::COLOR_DARKRED  // Set font color to green
            ]
            ],
        ]);

        $sheet->getStyle("L{$excelRow}:O{$excelRow}")->applyFromArray([

          'font' => [
            'bold'=>true,
            ],
        ]);
        $sheet->getStyle("N{$excelRow}")->applyFromArray([

          'font' => [
            'color' => [
              'argb'=>Color::COLOR_DARKRED  // Set font color to green
            ]
            ],
        ]);
      }
    }
}
