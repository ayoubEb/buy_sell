<?php

namespace App\Exports;

use App\Models\AchatPaiement;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AchatPaiementCsv implements FromCollection , WithHeadings , WithMapping , WithStrictNullComparison
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
        Str::upper('net à payer'),
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
        $achat->net_payer,
        $achatPaiement->payer,
        $achat->reste,
        $achatPaiement->date_paiement,
      ];
    }
}
