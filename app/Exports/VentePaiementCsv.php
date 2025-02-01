<?php

namespace App\Exports;

use App\Models\VentePaiement;
use App\Models\Client;
use App\Models\LigneVente;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class VentePaiementCsv implements FromCollection , WithHeadings , WithMapping
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
        $ventePaiement->payer,
        $vente->reste,
        $ventePaiement->date_paiement,
      ];
    }
}
