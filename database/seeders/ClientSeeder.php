<?php

namespace Database\Seeders;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ClientSeeder extends Seeder
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
        "raison_sociale" => "Adam Cooper",
        "adresse"        => "480 Passage Du Sommerard",
        "email"          => "alix_aubert@gmail.com",
        "ville"          => "Limoges",
        "ice"            => "041689336",
        "if_client"      => "575287430",
        "rc"             => "041689336",
        "telephone"      => '6454544833',
        "code_postal"    => 12600,
        "identifiant"    => Str::upper(Str::random(8)),
        "activite"       => "act",
        "moisCreation"   => date("m-Y"),
        "dateCreation"   => Carbon::now(),
        "created_at"     => Carbon::now(),
        "updated_at"     => Carbon::now(),
      ],
        [
        "raison_sociale" => "ayoub",
        "adresse"        => "480 Passage Du Sommerard",
        "email"          => "ayoub@gmail.com",
        "ville"          => "Limoges",
        "ice"            => "04166",
        "if_client"      => "5752874",
        "rc"             => "041689",
        "telephone"      => '6454543',
        "code_postal"    => 12600,
        "identifiant"    => Str::upper(Str::random(8)),
        "activite"       => "act",
        "moisCreation"   => date("m-Y"),
        "dateCreation"   => Carbon::now(),
        "created_at"     => Carbon::now(),
        "updated_at"     => Carbon::now(),
      ]

      ];

      Client::insert($data);
    }
}
