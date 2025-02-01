<?php

namespace App\Exports;

use App\Models\Fournisseur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FournisseurCsv implements FromCollection , WithHeadings , WithMapping
{
  protected $fournisseurs;
     /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $fournisseurs = Fournisseur::select("identifiant","raison_sociale","adresse","ville","code_postal","ice","rc" , "telephone","fix" , "pays" , "email" , "montant" , "payer" , "reste" ,"montant_demande","created_at")->get();
        return $this->fournisseurs = $fournisseurs;
    }


    public function headings(): array
    {
        return [
          Str::upper('Identifiant') ,
          Str::upper('Raison sociale') ,
          Str::upper('Adresse') ,
          Str::upper('Ville') ,
          Str::upper('Code postal') ,
          Str::upper('ICE') ,
          Str::upper('RC') ,
          Str::upper('Téléphone') ,
          Str::upper('Fix') ,
          Str::upper('Pays') ,
          Str::upper('Email') ,
          Str::upper('Montant') ,
          Str::upper('Payer') ,
          Str::upper('Reste') ,
          Str::upper('Montant demande') ,
          Str::upper('Date création')
        ];
    }

    public function map($fournisseur): array
    {
      return [
        $fournisseur->identifiant ?? 'N/A',
        $fournisseur->raison_sociale ?? 'N/A',
        $fournisseur->adresse ?? 'N/A',
        $fournisseur->ville ?? 'N/A',
        $fournisseur->code_postal ?? 'N/A',
        $fournisseur->ice ?? 'N/A',
        $fournisseur->rc ?? 'N/A',
        $fournisseur->telephone ?? 'N/A',
        $fournisseur->fix ?? 'N/A',
        $fournisseur->pays ?? 'N/A',
        $fournisseur->email ?? 'N/A',
        number_format($fournisseur->montant , 2 , "," , " ") ?? 0,
        number_format($fournisseur->payer , 2 , "," , " ") ?? 0,
        number_format($fournisseur->reste , 2 , "," , " ") ?? 0,
        number_format($fournisseur->montant_demande , 2 , "," , " ") ?? 0,
      ];
    }

}
