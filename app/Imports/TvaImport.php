<?php

namespace App\Imports;

use App\Models\TauxTva;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TvaImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if 'some_field' exists and is greater than 0

      if (empty($row['valeur'])) {
        return null;
      }
      $check_valeur = TauxTva::where("valeur",$row['valeur'])->exists();
      if($check_valeur == false)
      {
        return new TauxTva([
            'valeur'         => $row['valeur'],
            'nom'         => $row['nom'],
            'description' => $row['description'] ?? null,
        ]);
      }

      // Return null if the condition is not met
    }

    public function headingRow(): int
    {
        return 1;
    }
}
