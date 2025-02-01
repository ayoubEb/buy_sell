<?php

namespace App\Exports;

use App\Models\Categorie;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;
class CategorieCsv implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Categorie::select("id","nom","description")->get();
    }
    public function headings(): array
    {
        return [
            Str::upper("#id"),
            Str::upper("nom"),
            Str::upper("description"),
        ];
    }

    public function map($categorie): array
    {
      return [
        "#" . $categorie->id,
        $categorie->nom ?? 'N/A',
        $categorie->description ?? 'N/A',
      ];
    }

}
