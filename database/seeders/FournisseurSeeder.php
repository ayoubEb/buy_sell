<?php

namespace Database\Seeders;

use App\Models\Fournisseur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FournisseurSeeder extends Seeder
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
            "raison_sociale"  => "youssef",
            "adresse"         => "897 Boulevard Mouffetard",
            "ville"           => "Burundi",
            "code_postal"     => 13955,
            "pays"            => "Birmanie",
            "email"           => "gaspardlefebvre.marty@yahoo.fr",
            "telephone"           => "0602010405",
            "fix"             => "0502010460",
            "rc"              => 454545454,
            "ice"             => 123456789,
          ],
          [
            "raison_sociale"  => "samir",
            "adresse"         => "897 Boulevard Mouffetard",
            "ville"           => "Burundi",
            "code_postal"     => 13990,
            "pays"            => "Birmanie",
            "email"           => "gaspardlefebvre.mary@yahoo.fr",
            "telephone"           => "0602010405",
            "fix"             => "0502010460",
            "rc"              => 454545469,
            "ice"             => 123456889,
        ],
    ];
    Fournisseur::insert($data);
    }
}
