<?php

namespace App\Imports;

use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProduitImport implements ToModel , WithHeadingRow
{
  public $rows;



    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       // Check if 'designation' exists and is not empty
      if (empty($row['designation'])) {
        return null;
      }
      // Count products to generate a reference
      $count_pro = DB::table("produits")->count() + 1;

      $pro = Produit::create([
        'reference'    => "PRO-00" . $count_pro,
        'designation'  => $row['designation'],
        'quantite'     => $row['quantite'],
        'prix_vente'   => $row['prix_vente'],
        'prix_achat'   => $row['prix_vente'],
        'prix_revient' => $row['prix_vente'],
        'description'  => $row['description'] ?? null,
      ]);
        // Assign the row to the class property
        if (!isset($this->rows)) {
          $this->rows = [];
      }

      $this->rows[] = [ "pro_id"=>$pro->id , "qte"=>$pro->quantite]; // Keep track of processed rows

      return $pro;
    }



    public function headingRow(): int
    {
        return 1;
    }
}
