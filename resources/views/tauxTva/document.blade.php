<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des tvas</title>
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
  @include('layouts.top_doc',["title"=>"Liste des taux tva"])
  <table>
    <thead>
      <tr>
        <th>nom</th>
        <th>valeur</th>
        <th>description</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($tauxTvas as $taux)
        <tr>
          <td>
            {{ $taux->nom }}
          </td>
          <td>
            {{ $taux->valeur }}
          </td>
          <td>
            {{ $taux->description }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @include('layouts.bottom_doc')
</body>
</html>