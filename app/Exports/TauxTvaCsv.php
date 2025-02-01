<?php

namespace App\Exports;

use App\Models\TauxTva;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Str;
class TauxTvaCsv implements FromCollection , WithHeadings , WithMapping
{
 /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
      return TauxTva::select("id","nom","valeur","description")->get();
  }

  public function headings(): array
  {
    return [
      Str::upper('#id'),
      Str::upper('nom'),
      Str::upper('valeur'),
      Str::upper('description'),
    ];
  }

  public function map($tauxTva): array
  {
    return [
      "#".$tauxTva->id,
      $tauxTva->nom ?? 'N/A',
      ($tauxTva->valeur ?? 0)."%",
      $tauxTva->description ?? 'N/A',
    ];
  }
}
