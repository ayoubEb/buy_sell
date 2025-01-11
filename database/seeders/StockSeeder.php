<?php

namespace Database\Seeders;

use App\Models\DepotSuivi;
use App\Models\Stock;
use App\Models\StockDepot;
use App\Models\StockSuivi;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      for($i = 1 ; $i <=4 ; $i++){
        Stock::create([
          "produit_id" => $i,
          "num"        => "STO00-".$i,
          "initial"    => 1,
          "disponible"     => 100,
          "min"        => 1,
          "qte_alert"=>5,
          "date_stock" => Carbon::now(),
        ]);


       StockDepot::create([
          "stock_id"   => $i,
          "depot_id"   => $i,
          "quantite"   => 100,
          "disponible" => 100,
          "entre"      => 100,
          "statut"=>1,
        ]);


        StockSuivi::create([
          "stock_id"=>$i,
          "fonction"=>"initial",
          "quantite"=>100,
          "date_suivi"=>Carbon::today(),
        ]);
        DepotSuivi::create([
          "stock_depot_id"=>$i ,
          "date_suivi"=>Carbon::today(),
          "quantite"=>100,
          "operation"=>"initial"
        ]);
      }
    }
}
