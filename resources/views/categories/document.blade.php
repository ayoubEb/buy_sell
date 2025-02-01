<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Liste des catégories</title>
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

@include('layouts.top_doc',["title"=>"Liste des catégories"])
  <table>
    <thead>
      <tr>
        <th>nom</th>
        <th>description</th>
        <th>date création</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($categories as $categorie)
        <tr>
          <td>
            {{ $categorie->nom }}
          </td>
          <td>
            {{ $categorie->description }}
          </td>
          <td>
            {{ date("d/m/Y",strtotime($categorie->created_at)) }}
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>


  @include('layouts.bottom_doc')
</body>
</html>