<?php

namespace App\Exports;

use App\Models\AchatPaiement;
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
class AchatPaiementXlsx implements FromCollection ,  WithHeadings , WithMapping , WithStyles , ShouldAutoSize , WithStrictNullComparison
{
     /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return AchatPaiement::select("id","ligne_achat_id","num",'numero_operation',"type_paiement","statut","payer","date_paiement")->get();
    }

    public function headings(): array
    {
      return [
        Str::upper('#id'),
        Str::upper('reçu'),
        Str::upper('bon commande'),
        Str::upper('fournisseur'),
        Str::upper('numéro opération'),
        Str::upper('type paiement'),
        Str::upper('statut'),
        Str::upper('payer'),
        Str::upper('reste'),
        Str::upper('date paiement'),
      ];
    }
    public function map($achatPaiement): array
    {
      $achat = LigneAchat::where("id",$achatPaiement->ligne_achat_id)->first();
      $fournisseur = Fournisseur::where("id",$achat->fournisseur_id)->first();
      return [
        "#".$achatPaiement->id,
        $achatPaiement->num,
        $achat->num_achat,
        $fournisseur->raison_sociale,
        $achatPaiement->numero_operation,
        $achatPaiement->type_paiement,
        $achatPaiement->statut,
        $achatPaiement->payer,
        $achat->reste,
        $achatPaiement->date_paiement,
      ];
    }
    public function styles(Worksheet $sheet)
    {
      $sheet->getDefaultRowDimension()->setRowHeight(25);// Header row
      $sheet->getStyle('A1:K1')->applyFromArray([
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
      $sheet->getStyle('A:K')->applyFromArray([
        'alignment' => [
          'vertical' => Alignment::VERTICAL_CENTER,
        ],
      ]);
      $sheet->getStyle('H:J')->applyFromArray([
        'alignment' => [
          'horizontal' => Alignment::VERTICAL_CENTER,
        ],
      ]);
    }
}
