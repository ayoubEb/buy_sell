<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des produits</title>
</head>
<body>
  <style>
    * {
      margin: 1%;
      padding: 0;
      box-sizing: border-box;
      letter-spacing: 0.5px;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
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
      width: 100%;
      clear: both;
    }
  </style>

@include('layouts.top_doc',["title"=>"Liste des produits"])
@foreach ($produits as $produit)
  <article>

    <table>
      <tbody>
        <tr>
          <td class="pro" colspan="4">
            {{ $produit->designation }} =>
            {{ $produit->reference }}
          </td>
        </tr>
        <tr>
          <td class="item">
            catégorie
          </td>
          <td>
            {{ $produit->categorie && $produit->categorie->nom != '' ? $produit->categorie->nom : '' }}
          </td>
          <td class="item">
            statut
          </td>
          <td>
            {!! $produit->statut == 1 ? '<span style="color: green;">active</span>' : '<span style="color: red;">inactive</span>' !!}
          </td>
        </tr>
        <tr>
          <td class="item">
            depôt
          </td>
          <td>
            {!! $produit->check_depot == 1 ? '<span style="color: green;">active</span>' : '<span style="color: red;">inactive</span>' !!}
          </td>
          <td class="item">prix achat</td>
          <td>
            {{ number_format($produit->prix_achat , 2 , "," ," ") }} DHS
          </td>
        </tr>
        <tr>
          <td class="item">prix vente</td>
          <td>
            {{ number_format($produit->prix_vente , 2 , "," ," ") }} DHS
          </td>
          <td class="item">prix revient</td>
          <td>
            {{ number_format($produit->prix_revient , 2 , "," ," ") }} DHS
          </td>
        </tr>
        <tr>
          <td class="item">description</td>
          <td colspan="3">
            {{ $produit->description }}
          </td>
        </tr>


      </tbody>
    </table>
  </article>
  @endforeach
  @include('layouts.bottom_doc');
</body>
</html>