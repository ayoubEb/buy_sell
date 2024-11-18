<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $data = [

        [
            "nom"=>"Imprimantes",
            "created_at"=>Carbon::now(),
        ],
        [
            "nom"=>"Pc portable",
            "created_at"=>Carbon::now(),
        ],
    ];
    Categorie::insert($data);
    }
}
