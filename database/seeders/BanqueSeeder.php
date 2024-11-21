<?php

namespace Database\Seeders;

use App\Models\Banque;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BanqueSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
  */
  public function run()
  {
    $data = [
      [ "nom"=>"AL AKHDAR BANK" ],
      [ "nom"=>"AL BARID BANK" ],
      [ "nom"=>"ARAB BANK" ],
      [ "nom"=>"ATTIJARIWAFA BANK" ],
      [ "nom"=>"BANK AL YOUSR" ],
      [ "nom"=>"BANK ASSAFA" ],
      [ "nom"=>"BANK OF AFRICA" ],
      [ "nom"=>"BANQUE CENTRALE POPULAIRE" ],
      [ "nom"=>"BMCI" ],
      [ "nom"=>"BTI BANK" ],
      [ "nom"=>"CDG CAPITAL" ],
      [ "nom"=>"CFG BANK" ],
      [ "nom"=>"CIH BANK" ],
      [ "nom"=>"CITIBANK MAGHREB" ],
      [ "nom"=>"CREDIT AGRICOLE DU MAROC" ],
      [ "nom"=>"CREDIT DU MAROC" ],
      [ "nom"=>"DAR EL AMANE" ],
      [ "nom"=>"SOCIÉTÉ GÉNÉRALE MAROC" ],
      [ "nom"=>"UMNIA BANK" ],
    ];
    Banque::insert($data);
  }
}
