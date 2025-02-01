<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Categorie;
use App\Models\Depot;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\StockDepot;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class StockDepotCsv implements FromCollection , WithHeadings , WithMapping , WithStrictNullComparison
{
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    return  StockDepot::select("id","stock_id","depot_id","quantite","inactive","entre","sortie","disponible","check_default","statut","id")->get();
  }
  public function headings(): array
  {
      return [
          Str::upper('#id'),
          Str::upper('référence'),
          Str::upper('Catégorie'),
          Str::upper('Designation'),
          Str::upper('Numéro stock'),
          Str::upper('depôt'),
          Str::upper('Quantite'),
          Str::upper('disponible'),
          Str::upper('sortie'),
          Str::upper('entre'),
          Str::upper('inactive'),
          Str::upper('défault'),
          Str::upper('statut'),
      ];
  }

  public function map($stockDepot): array
  {
    $stock           = Stock::select("id","produit_id","num")->where("id",$stockDepot->stock_id)->first();
    $depot           = Depot::select("id","num_depot")->where("id",$stockDepot->depot_id)->first();
    $produit         = Produit::select("id","categorie_id","reference","designation")->first();
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
          "#".$stockDepot->id,
          $produit->reference,
          $categorie_nom,
          $produit->designation,
          $stock->num,
          $depot->num_depot,
          $stockDepot->quantite ,
          $stockDepot->disponible ,
          $stockDepot->sortie ,
          $stockDepot->entre,
          $stockDepot->inactive, // Corrected line
          $stockDepot->check_default == 1 ? 'oui' : 'non',
          $stockDepot->statut == 1 ? 'active' : 'inactive',
      ];
  }
}
