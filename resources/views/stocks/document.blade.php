<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des stocks</title>
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


  @include('layouts.top_doc',["title"=>"Liste des stocks"])
  @foreach ($stocks as $stock)
  <article>

    <table>
      <tbody>
        <tr>
          <td colspan="4" class="pro">
            {{
              $stock->produit &&
              $stock->produit->designation != '' ?
              $stock->produit->designation : ''
            }}&nbsp;/&nbsp;
            {{
              $stock->produit &&
              $stock->produit->reference != '' ?
              $stock->produit->reference : ''
            }}
          </td>
        </tr>
        <tr>
          <td class="item">numéro stock</td>
          <td>
            {{ $stock->num }}
          </td>
          <td class="item">quantite</td>
          <td>
            {{ $stock->quantite }}
          </td>
        </tr>
        <tr>
          <td class="item">disponible</td>
          <td>
            {{ $stock->disponible }}
          </td>
          <td class="item">reste</td>
          <td>
            {{ $stock->reste }}
          </td>
        </tr>
        <tr>
          <td class="item">min</td>
          <td>
            {{ $stock->min }}
          </td>
          <td class="item">max</td>
          <td>
            {{ $stock->max }}
          </td>
        </tr>
        <tr>
          <td class="item">sortie</td>
          <td>
            {{ $stock->sortie }}
          </td>
          <td class="item">alert</td>
          <td>
            {{ $stock->qte_alert }}
          </td>
        </tr>
        <tr>
          <td class="item">augmenter</td>
          <td>
            {{ $stock->qte_augmenter }}
          </td>
          <td class="item">achat réserver</td>
          <td>
            {{ $stock->qte_achatRes }}
          </td>
        </tr>
        <tr>
          <td class="item">achat</td>
          <td>
            {{ $stock->qte_achat }}
          </td>
          <td class="item">vente</td>
          <td>
            {{ $stock->qte_vente }}
          </td>
        </tr>
        <tr>
          <td class="item">vente réserver</td>
          <td>
            {{ $stock->qte_venteRes }}
          </td>
          <td class="item">date</td>
          <td>
            {{ $stock->date_stock }}
          </td>
        </tr>
      </tbody>
    </table>

    </article>
  @endforeach
  @include('layouts.bottom_doc')
</body>
</html>