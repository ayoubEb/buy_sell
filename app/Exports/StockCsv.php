<?php

namespace App\Exports;
use App\Models\Categorie;
use App\Models\Produit;
use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class StockCsv implements FromCollection , WithHeadings , WithMapping , WithStrictNullComparison
{
  public function collection()
  {
    return Stock::select("produit_id","num","quantite","disponible","reste","min","max","date_stock","sortie","qte_alert","qte_achat","qte_vente","qte_augmenter","qte_achatRes","qte_venteRes","id")->get();
  }

  public function headings(): array
  {
      return [
          Str::upper('référence'),
          Str::upper('Catégorie'),
          Str::upper('Designation'),
          Str::upper('Numéro'),
          Str::upper('Quantite'),
          Str::upper('disponible'),
          Str::upper('reste'),
          Str::upper('min'),
          Str::upper('max'),
          Str::upper('sortie'),
          Str::upper('alert'),
          Str::upper('achat'),
          Str::upper('vendu'),
          Str::upper('augmenter'),
          Str::upper('achat réserver'),
          Str::upper('vente réserver'),
          Str::upper('date création'),
      ];
  }

  public function map($stock): array
  {
    $produit = Produit::select("id","reference","designation","categorie_id")->where("id",$stock->produit_id)->first();
    $check_categorie = Categorie::where("id",$produit->categorie_id)->exists();
    if($check_categorie == true)
    {
      $categorie_nom = Categorie::where("id",$produit->categorie_id)->first()->nom;
    }
    else
    {
      $categorie_nom = null;

    }

      return [
          $produit->reference,
          $categorie_nom,
          $produit->designation,
          $stock->num,
          $stock->quantite,
          $stock->disponible,
          $stock->num,
          $stock->reste,
          $stock->min,
          $stock->max,
          $stock->sortie,
          $stock->qte_alert,
          $stock->qte_achat,
          $stock->qte_vente,
          $stock->qte_achatRes ,
          $stock->qte_venteRes ,
          $stock->date_stock,  // Format date
      ];
  }
}
