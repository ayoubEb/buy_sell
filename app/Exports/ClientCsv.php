<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientCsv implements FromCollection , WithHeadings
{
  protected $clients;

  /**
* @return \Illuminate\Support\Collection
*/
public function collection()
{
  $clients = Client::select("identifiant","if_client","raison_sociale","adresse","ville","code_postal","ice","rc" , "telephone","activite" , "email" , "montant" , "payer" , "reste" ,"montant_devis")->get();
  return $this->clients = $clients;
}


public function headings(): array
{
    return [
      Str::upper('Identifiant') ,
      Str::upper('if') ,
      Str::upper('Raison sociale') ,
      Str::upper('Adresse') ,
      Str::upper('Ville') ,
      Str::upper('Code postal') ,
      Str::upper('ICE') ,
      Str::upper('RC') ,
      Str::upper('Téléphone') ,
      Str::upper('activite') ,
      Str::upper('Email') ,
      Str::upper('Montant') ,
      Str::upper('Payer') ,
      Str::upper('Reste') ,
      Str::upper('Montant devis') ,
    ];
}

public function map($client): array
{
  return [
    $client->identifiant ?? 'N/A',
    $client->if_client ?? 'N/A',
    $client->raison_sociale ?? 'N/A',
    $client->adresse ?? 'N/A',
    $client->ville ?? 'N/A',
    $client->code_postal ?? 'N/A',
    $client->ice ?? 'N/A',
    $client->rc ?? 'N/A',
    $client->telephone ?? 'N/A',
    $client->activite ?? 'N/A',
    $client->email ?? 'N/A',
    number_format($client->montant , 2 , "," , " ") ?? 0,
    number_format($client->payer , 2 , "," , " ") ?? 0,
    number_format($client->reste , 2 , "," , " ") ?? 0,
    number_format($client->montant_devis , 2 , "," , " ") ?? 0,
  ];
}
}
