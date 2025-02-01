<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des ligne de ventes</title>
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
    @include('layouts.top_doc',["title"=>"Liste des ligne de vente"])
    @foreach ($ligneVentes as $ligneVente)
<article>
  <table>
    <tbody>
        <tr>
          <td colspan="6" class="pro">
            {{ $ligneVente->client && $ligneVente->client->raison_sociale != '' ? $ligneVente->client->raison_sociale : '' }} => {{ $ligneVente->num }}
          </td>
        </tr>

        <tr>
          <td class="item">
            identifant
          </td>
          <td>
            {{ $ligneVente->client && $ligneVente->client->identifiant != '' ? $ligneVente->client->identifiant : '' }}
          </td>
          <td class="item">
            nombre des produits
          </td>
          <td>
            {{ $ligneVente->nbrProduits }}
          </td>
          <td class="item">date</td>
          <td>
            {{ $ligneVente->dateCommande }}
          </td>
        </tr>

        <tr>

          <td class="item">date paiement</td>
          <td>
            {{ $ligneVente->datePaiement }}
          </td>
          <td class="item">
            prix ht
          </td>
          <td>
            {{ number_format($ligneVente->ht , 2 , "," ," ") }} DHS
          </td>
          <td class="item">
            prix ttc
          </td>
          <td>
            {{ number_format($ligneVente->ttc , 2 , "," ," ") }} DHS
          </td>
        </tr>

        <tr>

          <td class="item">statut</td>
          <td>
            {{ $ligneVente->statut}}
          </td>
          <td class="item">tva</td>
          <td>
            {{ $ligneVente->taux_tva}} %
          </td>
          <td class="item">net payer</td>
          <td>
            {{ number_format($ligneVente->net_payer , 2 , "," ," ") }} DHS
          </td>
        </tr>


        <tr>
          <td class="item">payer</td>
            <td>
              {{ number_format($ligneVente->payer , 2 , "," ," ") }} DHS
            </td>
            <td class="item">reste</td>
            <td>
              {{ number_format($ligneVente->reste , 2 ,"," , " ")  }} DH
            </td>
            <td class="item">date création</td>
            <td>
              {{ $ligneVente->dateCreation  }} DH
            </td>
        </tr>


        <tr>
          <td class="item">mt tva</td>
          <td>
            {{ number_format($ligneVente->ht_tva , 2 , "," ," ") }} DHS
          </td>
          <td class="item">commentaire</td>
          <td colspan="3">
            {{ $ligneVente->commentaire  }}
          </td>
        </tr>
      </tbody>
    </table>

  </article>
  @endforeach
</body>
</html>