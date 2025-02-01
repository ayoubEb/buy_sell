<?php

namespace App\Exports;
use App\Models\Fournisseur;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use Maatwebsite\Excel\Concerns\FromCollection;

class FournisseurXlsx implements FromCollection , WithHeadings , WithStyles , ShouldAutoSize , WithStrictNullComparison
{
  protected $fournisseurs;

      /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      $fournisseurs = Fournisseur::select("identifiant","raison_sociale","adresse","ville","code_postal","ice","rc" , "telephone","fix" , "pays" , "email" , "montant" , "payer" , "reste" ,"montant_demande","created_at")->get();
      return $this->fournisseurs = $fournisseurs;
    }


    public function headings(): array
    {
        return [
          Str::upper('Identifiant') ,
          Str::upper('Raison sociale') ,
          Str::upper('Adresse') ,
          Str::upper('Ville') ,
          Str::upper('Code postal') ,
          Str::upper('ICE') ,
          Str::upper('RC') ,
          Str::upper('Téléphone') ,
          Str::upper('Fix') ,
          Str::upper('Pays') ,
          Str::upper('Email') ,
          Str::upper('Montant') ,
          Str::upper('Payer') ,
          Str::upper('Reste') ,
          Str::upper('Montant demande') ,
        ];
    }

    public function map($fournisseur): array
    {
      return [
        $fournisseur->identifiant ?? 'N/A',
        $fournisseur->raison_sociale ?? 'N/A',
        $fournisseur->adresse ?? 'N/A',
        $fournisseur->ville ?? 'N/A',
        $fournisseur->code_postal ?? 'N/A',
        $fournisseur->ice ?? 'N/A',
        $fournisseur->rc ?? 'N/A',
        $fournisseur->telephone ?? 'N/A',
        $fournisseur->fix ?? 'N/A',
        $fournisseur->pays ?? 'N/A',
        $fournisseur->email ?? 'N/A',
        number_format($fournisseur->montant , 2 , "," , " ") ?? 0,
        number_format($fournisseur->payer , 2 , "," , " ") ?? 0,
        number_format($fournisseur->reste , 2 , "," , " ") ?? 0,
        number_format($fournisseur->montant_demande , 2 , "," , " ") ?? 0,
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

      foreach ($this->fournisseurs as $rowIndex => $stockDepot) {
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
