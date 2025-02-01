<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Categorie;
use App\Models\Produit;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProduitCsv implements FromCollection , WithHeadings , WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      return Produit::select("id","reference","designation","statut","check_depot","check_stock","description","prix_achat","prix_vente","prix_revient","created_at")->get();
    }

    public function headings(): array
    {
        return [
            Str::upper('#id'),
            Str::upper('Référence'),
            Str::upper('Catégorie'),
            Str::upper('Designation'),
            Str::upper('Statut'),
            Str::upper('Depot'),
            Str::upper('Stock'),
            Str::upper('Description'),
            Str::upper('Prix Achat'),
            Str::upper('Prix Vente'),
            Str::upper('Prix Revient'),
            Str::upper('date création'),
        ];
    }

    public function map($produit): array
    {
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
            "#" . $produit->id,
            $produit->reference,
            $categorie_nom,
            $produit->designation,
            $produit->statut      == 1 ? 'active' : 'inactive',
            $produit->check_depot == 1 ? 'active' : 'inactive',
            $produit->check_stock == 1 ? 'active' : 'inactive',
            $produit->description,
            number_format               ($produit->prix_achat, 2, ',', ' '),     // Format as currency
            number_format               ($produit->prix_vente, 2, ',', ' '),     // Format as currency
            number_format               ($produit->prix_revient, 2, ',', ' '),   // Format as currency
            $produit->created_at->format('d/m/Y'),                               // Format date
        ];
    }
}
