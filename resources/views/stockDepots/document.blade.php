<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des stocks depôts</title>
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
  @include('layouts.top_doc',["title"=>"Liste des stocks depôts"])
  @foreach ($stockDepots as $stockDepot)
  <article>
    <table>
      <tbody>
        <tr>
          <td colspan="4" class="pro">
            {{
              $stockDepot->produit &&
              $stockDepot->produit->designation != '' ?
              $stockDepot->produit->designation : ''
            }}
              =>
              {{
                $stockDepot->produit->reference
              }}
          </td>
        </tr>
        <tr>
          <td class="item">
            stock
          </td>
          <td>
              {{
                $stockDepot->stock->num
              }}
          </td>
          <td class="item">
            depôt
          </td>
          <td>
              {{
                $stockDepot->depot->num_depot
              }}
          </td>
        </tr>

        <tr>
          <td class="item">
            adresse depôt
          </td>
          <td>
              {{ $stockDepot->depot->adresse }}
          </td>
          <td class="item">
            quantite
          </td>
          <td>
              {{ $stockDepot->quantite }}
          </td>
        </tr>

        <tr>
          <td class="item">disponible</td>
          <td>
            {{ $stockDepot->disponible }}
          </td>
          <td class="item">entre</td>
          <td>
            {{ $stockDepot->entre }}
          </td>
        </tr>
        <tr>
          <td class="item">sortie</td>
          <td>
            {{ $stockDepot->sortie }}
          </td>
          <td class="item">inactive</td>
          <td>
            {{ $stockDepot->inactive }}
          </td>
        </tr>
        <tr>
          <td class="item">statut</td>
          <td>
            {!! $stockDepot->statut == 1 ? '<span style="color: green;margin:0;">mouvement</span>' : '<span style="color: red;margin:0;">non mouvement</span>' !!}
          </td>
          <td class="item">défault</td>
          <td>
            {!! $stockDepot->check_default == 1 ? '<span style="color: green;margin:0;">oui</span>' : '<span style="color: red;margin:0;">non</span>' !!}
          </td>
        </tr>


      </tbody>
    </table>

  </article>
  @endforeach
  @include('layouts.bottom_doc')
</body>
</html>