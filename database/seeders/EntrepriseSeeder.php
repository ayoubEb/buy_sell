<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EntrepriseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Entreprise::create([
        "ice"            => "1212121245",
        "raison_sociale" => "web",
        "if"             => "512121",
        "cnss"           => "512",
        "patente"        => "512121",
        "rc"             => "512121",
        "adresse"        => "adresse",
        "ville"          => "ville",
        "code_postal"    => 12125,
        "telephone"      => "0632143214",
        "fix"            => "0632143214",
        "email"          => "societe@gmai.com",
      ]);
    }
}
