<?php

namespace App\Imports;

use App\Models\Depot;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DepotImport implements ToModel , WithHeadingRow
{
  /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Check if 'some_field' exists and is greater than 0

      if (empty($row['num'])) {
        return null;
      }

      return new Depot([
          'num_depot'         => $row['num'],
          'adresse' => $row['adresse'] ?? null,
      ]);

      // Return null if the condition is not met
    }

    public function headingRow(): int
    {
        return 1;
    }
}
