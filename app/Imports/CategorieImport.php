<?php

namespace App\Imports;

use App\Models\Categorie;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class CategorieImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if 'some_field' exists and is greater than 0

      if (empty($row['nom'])) {
        return null;
      }

      return new Categorie([
          'nom'         => $row['nom'],
          'description' => $row['description'] ?? null,
      ]);

      // Return null if the condition is not met
    }

    public function headingRow(): int
    {
        return 1;
    }
}
