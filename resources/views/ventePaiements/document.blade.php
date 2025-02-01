<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des ventes paiements</title>
</head>
<body>
  <style>
    * {
      margin: 7px 15px;
      padding: 0;
      box-sizing: border-box;
      letter-spacing: 0.5px;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    article
    {
      width: 100%;
      margin: 0 !important;
      clear: both;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }
    table thead {
      background: #004E64;
    }
    table thead th {
      font-size: xx-small;
      color: white;
      margin: 7px;
    }
    .pro
    {
      background: #004E64;
      color: white

    }
    td.item{
      font-weight: bold;
      text-transform: uppercase;
      background: wheat;
    }
    table tbody td {
      font-size: 9px;
    }
    table th, table td {
      text-align: left;
      padding-top: 7px;
      padding-left: 5px;
      padding-bottom: 7px;
      text-transform: uppercase;

    }
    table tbody {
      border: 0.4px #004E64 solid;
    }

    article{
      margin-bottom: 1rem;
    }
  </style>
    @include('layouts.top_doc',["title"=>"Liste des achats paiements"])
    <article>
      <table>
        <thead>
          <tr>
            <th>facture</th>
            <th>client</th>
            <th>type paiement</th>
            <th>date paiement</th>
            <th>montant</th>
            <th>statut</th>
          </tr>
        </thead>
        <tbody>
      @foreach ($ventePaiements as $ventePaiement)
        <tr>
          <td>
            {{ $ventePaiement->facture && $ventePaiement->facture->num != '' ? $ventePaiement->facture->num : '' }}
          </td>
          <td>
            {{ $ventePaiement->facture && $ventePaiement->facture->client && $ventePaiement->facture->client->raison_sociale  != '' ? $ventePaiement->facture->client->raison_sociale  : '' }}
          </td>
          <td>
            {{ $ventePaiement->type_paiement }}
          </td>
          <td>
            {{ $ventePaiement->date_paiement }}
          </td>
          <td>
            {{ number_format($ventePaiement->payer , 2 , "," ," ") }} DH
          </td>
          <td>
            {{ $ventePaiement->statut }}
          </td>
        </tr>






        @endforeach
      </tbody>
    </table>

  </article>
</body>
</html>