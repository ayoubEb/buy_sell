<?php

namespace App\Exports;

use App\Models\VentePaiement;
use App\Models\Client;
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
class VentePaiementXlsx implements FromCollection ,  WithHeadings , WithMapping , WithStyles , ShouldAutoSize , WithStrictNullComparison
{
  /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return VentePaiement::select("id","ligne_vente_id","num",'numero_operation',"type_paiement","statut","payer","date_paiement")->get();
    }

    public function headings(): array
    {
      return [
        Str::upper('#id'),
        Str::upper('reçu'),
        Str::upper('facture'),
        Str::upper('client'),
        Str::upper('numéro opération'),
        Str::upper('type paiement'),
        Str::upper('statut'),
        Str::upper('net à payer'),
        Str::upper('payer'),
        Str::upper('reste'),
        Str::upper('date paiement'),
      ];
    }
    public function map($ventePaiement): array
    {
      $vente = LigneVente::where("id",$ventePaiement->ligne_vente_id)->first();
      $fournisseur = Client::where("id",$vente->client_id)->first();
      return [
        "#".$ventePaiement->id,
        $ventePaiement->num,
        $vente->num,
        $fournisseur->raison_sociale,
        $ventePaiement->numero_operation,
        $ventePaiement->type_paiement,
        $ventePaiement->statut,
        $vente->net_payer,
        $ventePaiement->payer,
        $vente->reste,
        $ventePaiement->date_paiement,
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
