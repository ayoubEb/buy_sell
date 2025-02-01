<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Entreprise;
use App\Models\LigneVente;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LigneVenteCsv implements FromCollection , WithHeadings , WithMapping
{
  protected $ligneVentes;

  /**
    * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    return LigneVente::select("client_id","entreprise_id","num","statut","ht","ht_tva","remise"  , "taux_tva" , "ttc", "net_payer", "payer" , "reste" , "payer" , "dateCommande","datePaiement",'nbrProduits','commentaire' )->get();
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
}
