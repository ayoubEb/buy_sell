<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des depôts</title>
</head>
<body>
  <style>
    * {
      margin: 1.5%;
      padding: 0;
      box-sizing: border-box;
      letter-spacing: 0.5px;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
    }
    h6
    {
      text-align: center;
      text-transform: uppercase;
      width: 20%;
      margin: auto;
      margin-bottom: 1rem
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
    table tbody td {
      font-size: 9px;
    }
    table th, table td {
      padding-top: 7px;
      padding-bottom: 7px;
      text-transform: uppercase;
      text-align: center;
    }
    table tr {
      border: 0.4px #004E64 solid;
    }
    img
    {
      width: 5rem;
    }
  </style>
  @include('layouts.top_doc',["title"=>"Liste des depôts"])
  <table>
    <thead>
      <tr>
        <th>numéro</th>
        <th>adresse</th>
        <th>quantite</th>
        <th>entre</th>
        <th>sortie</th>
        <th>statut</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($depots as $depot)
        <tr>
          <td>
            {{ $depot->num_depot }}
          </td>
          <td>
            {{ $depot->adresse }}
          </td>
          <td>
            {{ $depot->quantite }}
          </td>
          <td>
            {{ $depot->entre }}
          </td>
          <td>
            {{ $depot->sortie }}
          </td>
          <td>
            {{ $depot->statut == 1 ? 'Active' : 'Inactive' }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
  @include('layouts.bottom_doc')
</body>
</html>