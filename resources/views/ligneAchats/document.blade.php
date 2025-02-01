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
    @include('layouts.top_doc',["title"=>"Liste des ligne d'achats"])
    @foreach ($ligneAchats as $ligneAchat)
<article>
  <table>
    <tbody>
        <tr>
          <td colspan="6" class="pro">
            {{ $ligneAchat->fournisseur && $ligneAchat->fournisseur->raison_sociale != '' ? $ligneAchat->fournisseur->raison_sociale : '' }} => {{ $ligneAchat->num_achat }}
          </td>
        </tr>

        <tr>
          <td class="item">
            identifant
          </td>
          <td>
            {{ $ligneAchat->fournisseur && $ligneAchat->fournisseur->identifiant != '' ? $ligneAchat->fournisseur->identifiant : '' }}
          </td>
          <td class="item">
            nombre des produits
          </td>
          <td>
            {{ $ligneAchat->nombre_achats }}
          </td>
          <td class="item">date</td>
          <td>
            {{ $ligneAchat->date_achat }}
          </td>
        </tr>

        <tr>

          <td class="item">date paiement</td>
          <td>
            {{ $ligneAchat->datePaiement }}
          </td>
          <td class="item">
            prix ht
          </td>
          <td>
            {{ number_format($ligneAchat->ht , 2 , "," ," ") }} DHS
          </td>
          <td class="item">
            prix ttc
          </td>
          <td>
            {{ number_format($ligneAchat->ttc , 2 , "," ," ") }} DHS
          </td>
        </tr>

        <tr>

          <td class="item">statut</td>
          <td>
            {{ $ligneAchat->statut}}
          </td>
          <td class="item">tva</td>
          <td>
            {{ $ligneAchat->taux_tva}} %
          </td>
          <td class="item">net payer</td>
          <td>
            {{ number_format($ligneAchat->net_payer , 2 , "," ," ") }} DHS
          </td>
        </tr>


        <tr>
          <td class="item">payer</td>
            <td>
              {{ number_format($ligneAchat->payer , 2 , "," ," ") }} DHS
            </td>
            <td class="item">reste</td>
            <td>
              {{ number_format($ligneAchat->reste , 2 ,"," , " ")  }} DH
            </td>
            <td class="item">date création</td>
            <td>
              {{ $ligneAchat->dateCreation  }} DH
            </td>
        </tr>


        <tr>
          <td class="item">mt tva</td>
          <td>
            {{ number_format($ligneAchat->ht_tva , 2 , "," ," ") }} DHS
          </td>
          <td class="item">commentaire</td>
          <td colspan="3">
            {{ $ligneAchat->commentaire  }}
          </td>
        </tr>
      </tbody>
    </table>

  </article>
  @endforeach
</body>
</html>