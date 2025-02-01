<?php

namespace App\Exports;

use App\Models\Entreprise;
use App\Models\Fournisseur;
use App\Models\LigneAchat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LigneAchatCsv implements FromCollection , WithHeadings
{
     /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      return LigneAchat::select("fournisseur_id","entreprise_id","num_achat","statut","ht","nombre_achats","date_achat","datePaiement"  , "taux_tva" , "ttc", "net_payer", "payer","mt_tva" , "reste" , "payer" , "dateCreation" )->get();
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
}
