<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Depot;
use Illuminate\Support\Str;

class DepotCsv implements FromCollection , WithHeadings , WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Depot::select("id","num_depot","adresse","quantite","disponible","entre","statut","sortie","id")->get();
    }


    public function headings(): array
    {
      return [
        Str::upper('#id'),
        Str::upper('numéro'),
        Str::upper('adresse'),
        Str::upper('quantite'),
        Str::upper('disponible'),
        Str::upper('entre'),
        Str::upper('sortie'),
        Str::upper('statut'),
      ];
    }

    public function map($depot): array
    {
      return [
        "#".$depot->id,
        $depot->num_depot,
        $depot->adresse,
        $depot->quantite,
        $depot->disponible,
        $depot->entre,
        $depot->sortie,
        $depot->statut == 1 ? 'active' : 'inactive',
      ];
    }
}
