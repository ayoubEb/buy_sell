<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des ligne d'achats</title>
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
    @include('layouts.top_doc',["title"=>"Liste des achats paiements])
    <article>
      <table>
        <thead>
          <tr>
            <th>bon</th>
            <th>fournisseur</th>
            <th>type paiement</th>
            <th>date paiement</th>
            <th>montant</th>
            <th>statut</th>
          </tr>
        </thead>
        <tbody>
      @foreach ($achatPaiements as $achatPaiement)
        <tr>
          <td>
            {{ $achatPaiement->ligne && $achatPaiement->ligne->num_achat != '' ? $achatPaiement->ligne->num_achat : '' }}
          </td>
          <td>
            {{ $achatPaiement->ligne && $achatPaiement->ligne->fournisseur && $achatPaiement->ligne->fournisseur->raison_sociale  != '' ? $achatPaiement->ligne->fournisseur->raison_sociale  : '' }}
          </td>
          <td>
            {{ $achatPaiement->type_paiement }}
          </td>
          <td>
            {{ $achatPaiement->date_paiement }}
          </td>
          <td>
            {{ number_format($achatPaiement->payer , 2 , "," ," ") }} DH
          </td>
          <td>
            {{ $achatPaiement->statut }}
          </td>
        </tr>






        @endforeach
      </tbody>
    </table>

  </article>
</body>
</html>