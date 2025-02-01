<?php

namespace App\Exports;

use App\Models\Entreprise;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
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
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class LigneAchatXlsx implements FromCollection , WithHeadings , WithStyles , ShouldAutoSize , WithStrictNullComparison , WithMapping
{
  protected $ligneAchats;

    /**
    * @return \Illuminate\Support\Collection
    */
  public function collection()
  {
    $ligneAchats = LigneAchat::select("fournisseur_id","entreprise_id","num_achat","statut","ht","nombre_achats","date_achat","datePaiement"  , "taux_tva" , "ttc", "net_payer", "payer","mt_tva" , "reste" , "payer" , "dateCreation" )->get();
    return $this->ligneAchats = $ligneAchats;
  }


  public function headings(): array
  {
      return [
        Str::upper('fournisseur') ,
        Str::upper('identifiant') ,
        Str::upper('entreprise') ,
        Str::upper('numéro') ,
        Str::upper('statut') ,
        Str::upper('nombre produits') ,
        Str::upper('date achat') ,
        Str::upper('date paiement') ,
        Str::upper('prix ht') ,
        Str::upper('taux tva') ,
        Str::upper('montant tva') ,
        Str::upper('montant ttc') ,
        Str::upper('net à payer') ,
        Str::upper('payer') ,
        Str::upper('reste') ,
        Str::upper('date création') ,
      ];
  }

  public function map($ligneAchat): array
  {
    $fournisseur = Fournisseur::select("id","raison_sociale","identifiant")->where("id",$ligneAchat->fournisseur_id)->first();
    $entreprise = Entreprise::where("id",$ligneAchat->entreprise_id)->first();
    return [
      $fournisseur->raison_sociale ?? 'N/A',
      $fournisseur->identifiant ?? 'N/A',
      $entreprise->raison_sociale ?? 'N/A',
      $ligneAchat->num_achat ?? 'N/A',
      $ligneAchat->statut ?? 'N/A',
      $ligneAchat->nombre_achats ?? 'N/A',
      $ligneAchat->date_achat ?? 'N/A',
      $ligneAchat->datePaiement ?? 'N/A',
      number_format($ligneAchat->ht , 2 , "," , " ") ?? 0,
      number_format($ligneAchat->taux_tva , 2 , "," , " ") ?? 0,
      number_format($ligneAchat->mt_tva , 2 , "," , " ") ?? 0,
      number_format($ligneAchat->ttc , 2 , "," , " ") ?? 0,
      number_format($ligneAchat->net_payer , 2 , "," , " ") ?? 0,
      number_format($ligneAchat->payer , 2 , "," , " ") ?? 0,
      number_format($ligneAchat->reste , 2 , "," , " ") ?? 0,
      $ligneAchat->dateCreation ?? 'N/A',
    ];
  }

  public function columnFormats(): array
  {
      // return [
      //     'F' => NumberFormat::FORMAT_NUMBER,
      //     'G' => NumberFormat::FORMAT_NUMBER,
      //     'H' => NumberFormat::FORMAT_NUMBER,
      //     'I' => NumberFormat::FORMAT_NUMBER,
      //     'J' => NumberFormat::FORMAT_NUMBER,
      // ];
    // Define the columns that need number formatting
    $columns = ['I' , 'J' , 'K' , 'L' , 'M' , 'N' , 'O'];

    // Use array_map to create the format array
    return array_fill_keys($columns, NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
  }


  public function styles(Worksheet $sheet)
  {
    $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
    $sheet->getStyle('A1:P1')->applyFromArray([
      'font' => [
          'bold' => true,
          'size' => 10,
          'name' => 'Cambria',
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
    $sheet->getStyle('D:P')->applyFromArray([
      'alignment' => [
          'vertical' => Alignment::VERTICAL_CENTER,
          'horizontal' => Alignment::HORIZONTAL_CENTER,
      ],
    ]);

    // return [];
    foreach ($this->ligneAchats as $rowIndex => $stockDepot) {
      $excelRow = $rowIndex + 2; // Data starts at row 2 (row 1 is headers)
      $sheet->getStyle("N{$excelRow}")->applyFromArray([

        'font' => [
            'color' => [
              'argb'=>Color::COLOR_DARKGREEN  // Set font color to green
            ]
        ],
      ]);
      $sheet->getStyle("O{$excelRow}")->applyFromArray([

        'font' => [
          'color' => [
            'argb'=>Color::COLOR_DARKRED  // Set font color to green
          ]
          ],
      ]);

      $sheet->getStyle("I{$excelRow}:O{$excelRow}")->applyFromArray([

        'font' => [
          'bold'=>true,
          ],
      ]);
      $sheet->getStyle("O{$excelRow}")->applyFromArray([

        'font' => [
          'color' => [
            'argb'=>Color::COLOR_DARKRED  // Set font color to green
          ]
          ],
      ]);
    }
  }
}
