<?php

namespace Database\Seeders;

use App\Models\Depot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i = 1 ; $i <= 5 ; $i++){
        Depot::create([
          "num_depot"  => "DEP-00".$i,
          "adresse"    => "adresse ".$i,
          "quantite"   => 100,
          "entre"      => 100,
          "disponible" => 100,
          "statut"=>1,
        ]);
      }

    }
}
