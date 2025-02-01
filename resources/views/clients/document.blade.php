<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des clients</title>
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
      margin: 0;
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
    @include('layouts.top_doc',["title"=>"Liste des clients"])
<article>
  <table>
    <tbody>
      @foreach ($clients as $client)
        <tr>
        <td colspan="4" class="pro">
          {{ $client->raison_sociale }} => {{ $client->ice }}
        </td>
        </tr>
        <tr>
          <td class="item">
            identifant
          </td>
          <td>
            {{ $client->identifiant }}
          </td>
          <td class="item">
            adresse
          </td>
          <td>
            {{ $client->adresse }}
          </td>
        </tr>
        <tr>
          <td class="item">téléphone</td>
          <td>
            {{ $client->telephone}}
          </td>
          <td class="item">ice</td>
          <td>
            {{ $client->ice }}
          </td>
        </tr>
        <tr>
          <td class="item">ville</td>
          <td>
            {{ $client->ville }}
          </td>
          <td class="item">code_postal</td>
          <td>
            {{ $client->code_postal }}
          </td>
        </tr>
        <tr>
          <td class="item">ice</td>
          <td>
            {{ $client->ice }}
          </td>
          <td class="item">rc</td>
          <td>
            {{ $client->rc }}
          </td>
        </tr>

        <tr>
          <td class="item">activité</td>
          <td>
            {{ $client->activite }}
          </td>
          <td class="item">ville</td>
          <td>
            {{ $client->email }}
          </td>
        </tr>
        <tr>
          <td class="item">montant</td>
          <td>
            {{ number_format($client->montant , 2 ,"," , " ")  }} DH
          </td>
          <td class="item">payer</td>
          <td>
            {{ number_format($client->payer , 2 ,"," , " ")  }} DH
          </td>
        </tr>
        <tr>
          <td class="item">reste</td>
          <td>
            {{ number_format($client->reste , 2 ,"," , " ")  }} DH
          </td>
          <td class="item">montant devis</td>
          <td>
            {{ number_format($client->montant_devis , 2 ,"," , " ")  }} DH
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

</article>
</body>
</html>