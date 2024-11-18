<?php

namespace Database\Seeders;

use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i = 1 ; $i <= 8 ; $i++)
      {
       $pro = Produit::create([
          'reference'    => 'LM-601'.$i,
          'designation'  => 'MICROPHONES',
          'description'  => 'BETA DYNAMIC MICROPHONE',
          'prix_achat'   => 5 . $i,
          'prix_revient' => 4 . $i,
          'quantite'     => 100,
          'created_at'   => '2023-07-07 20:52:52',
          'updated_at'   => '2023-07-12 14:44:31'
        ]);

        Stock::create([
          "produit_id" => $pro->id,
          "disponible" => 100,
        ]);
    }
    }
}
