<?php

namespace App\Exports;

use App\Models\Client;
use App\Models\Entreprise;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
use App\Models\LigneVente;
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

class LigneVenteXlsx implements FromCollection ,  WithHeadings , WithStyles , ShouldAutoSize , WithStrictNullComparison , WithMapping
{
  protected $ligneVentes;

  /**
    * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $ligneVentes = LigneVente::select("client_id","entreprise_id","num","statut","ht","ht_tva","remise"  , "taux_tva" , "ttc", "net_payer", "payer" , "reste" , "payer" , "dateCommande","datePaiement",'nbrProduits','commentaire' )->get();
    return $this->ligneVentes = $ligneVentes;
  }


  public function headings(): array
  {
      return [
        Str::upper('client') ,
        Str::upper('identifiant') ,
        Str::upper('entreprise') ,
        Str::upper('numéro') ,
        Str::upper('statut') ,
        Str::upper('nombre produits') ,
        Str::upper('date commande') ,
        Str::upper('date paiement') ,
        Str::upper('remise') ,
        Str::upper('prix ht') ,
        Str::upper('taux tva') ,
        Str::upper('montant tva') ,
        Str::upper('montant ttc') ,
        Str::upper('net à payer') ,
        Str::upper('payer') ,
        Str::upper('reste') ,
        Str::upper('commentaire') ,
        Str::upper('date création') ,
      ];
  }

  public function map($ligneCommande): array
  {
    $client = Client::select("id","raison_sociale","identifiant")->where("id",$ligneCommande->fournisseur_id)->first();
    $entreprise = Entreprise::where("id",$ligneCommande->entreprise_id)->first();
    return [
      $client->raison_sociale ?? 'N/A',
      $fournisseur->identifiant ?? 'N/A',
      $entreprise->raison_sociale ?? 'N/A',
      $ligneCommande->num_achat ?? 'N/A',
      $ligneCommande->statut ?? 'N/A',
      $ligneCommande->nbrProduits ?? 'N/A',
      $ligneCommande->dateCommande ?? 'N/A',
      $ligneCommande->datePaiement ?? 'N/A',
      $ligneCommande->remise ?? 0,
      $ligneCommande->ht ?? 0,
      $ligneCommande->taux_tva ?? 0,
      $ligneCommande->ht_tva ?? 0,
      $ligneCommande->ttc ?? 0,
      $ligneCommande->net_payer ?? 0,
      $ligneCommande->payer ?? 0,
      $ligneCommande->reste ?? 0,
      $ligneCommande->commentaire ?? 'N/A',
      $ligneCommande->dateCommande ?? 'N/A',
    ];
  }


  public function styles(Worksheet $sheet)
  {
    $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
    $sheet->getStyle('A1:R1')->applyFromArray([
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
    $sheet->getStyle('A:R')->applyFromArray([
      'alignment' => [
          'vertical' => Alignment::VERTICAL_CENTER,
      ],
    ]);

    $sheet->getStyle('D:P')->applyFromArray([
      'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
      ],
    ]);

    $sheet->getStyle('R')->applyFromArray([
      'alignment' => [
          'horizontal' => Alignment::HORIZONTAL_CENTER,
      ],
    ]);

    // return [];
    foreach ($this->ligneVentes as $rowIndex => $stockDepot) {
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
