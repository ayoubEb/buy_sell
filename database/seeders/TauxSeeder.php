<?php

namespace Database\Seeders;

use App\Models\TauxTva;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TauxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $valeurs = [ "10","2.1","5.5","20" ];
      foreach($valeurs as $valeur){
        TauxTva::create([
          "valeur"=>$valeur,
          "created_at"=>Carbon::today(),
          "updated_at"=>Carbon::today(),
        ]);
      }
    }
}
