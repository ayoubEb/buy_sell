<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>demande des prix</title>
  <!-- App favicon -->
  <link rel="icon" type="image/png" href="{{ public_path('assets/img/logo.png') }}" />
    {{-- @vite(["ressources/scss/document.scss"]) --}}
</head>
<body>
  <style>
    body{
      /* letter-spacing:.5px; */
      font-family: Arial, sans-serif;
      margin     : 0;
      padding    : 0;
    }
    header{
      width: 100%;
    }
    header img{
      width: 5rem;
    }
    hr
    {
      height: .5rem;
      background: #ED7D3A;;
      width: 100%;
      border: none
    }
    .top-page{
      width: 100%;
      margin-bottom: 8rem;
    }
    .fournisseur{
      margin       : 0 !important;
      padding      : 5px !important;
      border       : 1px solid black;
      width        : 50%;
      float        : left;
      border-radius: .375rem;
      font-size: 14.5px;
    }

    .bloc-right{
      width: 20%;
      float: right;
    }
    ul{
      list-style: none;
      margin: 0 !important;
      padding: 0 !important;
    }
    ul li:nth-child(1),
    ul li:nth-child(2),
    ul li:nth-child(3){
      padding      : 0;
      margin-bottom: .5rem !important;
      text-transform: uppercase;

    }

    h6{
      text-transform: uppercase;
      letter-spacing: .6px;
      font-size: 18px;
      margin: 1rem 0;
      text-align: center;
      border: 1px solid black;
      padding-top: 1rem;
      padding-bottom: 1rem;
      border-radius: .375rem;
    }

    .produits{
      clear        : both;
      width        : 100%;
      margin-bottom: 1rem;
    }
    table
    {
        width: 100%;
        border-collapse: collapse;
    }
    table th, table td {
        border: 1px solid #ddd;
        padding: 8px 10px;
        text-align: left;
        font-size: 12px;
    }
    table th {
      background-color: #f4f4f4;
      text-transform: uppercase;
      font-size: 10.5px;
      letter-spacing: .5px;
    }

    footer
    {
      width: 100%;
      margin: 1rem 0 0 0;
      padding: 0
    }

  </style>

  <header>
    <img src="{{ public_path('assets/img/logo.png') }}" alt="">
  </header>

  <hr>

  <div class="top-page">
    <div class="fournisseur">
      <ul>
        <li>{{ $fournisseur->raison_sociale  }} </li>
        <li>{{ $fournisseur->telephone  }} </li>
        <li>{{ $fournisseur->adresse  }} - {{ $fournisseur->ville }} </li>
        <li>{{ $fournisseur->email  }} </li>
      </ul>
    </div>

    <div class="bloc-right">
      <table>
        <thead>
          <tr>
            <th>date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $ligneAchat->date_achat }} </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <h6>
    demande de prix : {{ $ligneAchat->num_achat }}
  </h6>

  <div class="produits">
    <table>
        <thead>
            <tr>
                <th>référence</th>
                <th>designation</th>
                <th>qté</th>
                <th>prix vente</th>
                <th>remise %</th>
                <th>montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produits as $achat)
                <tr>
                    <td>
                      {{ $achat->produit->reference ?? ''}}
                    </td>
                    <td> {{ $achat->produit->designation ?? ''}} </td>
                    <td> {{ $achat->quantite ?? ''}} </td>
                    <td> {{ number_format($achat->prix , 2 , "," , " ")." DH"}} </td>
                    <td> {{ number_format($achat->remise , 2 , "," , " ")." %"}} </td>
                    <td> {{ number_format($achat->montant , 2 , "," , " ")." DH"}} </td>
                </tr>

            @endforeach
            @for ($i = 1; $i <= 10 - count($produits); $i++)
                <tr class="rowsNull">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                </tr>
            @endfor
        </tbody>

    </table>

  </div>


    <table>
      <thead>
        <tr>
          <th>nombre</th>
          {{-- <th>remise</th> --}}
          <th>montant ht</th>
          <th>tva</th>
          <th>ttc</th>
          <th>net à payer</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td> {{ count($produits) }} </td>
          {{-- <td> {{ number_format($ligneAchat->remise , 2 , "," ," ") . " %" }} </td> --}}
          <td> {{ number_format($ligneAchat->ht , 2 , "," ," ") . " DH" }} </td>
          <td> {{ number_format($ligneAchat->tva , 2 , "," ," ") . " %" }} </td>
          <td> {{ number_format($ligneAchat->ttc , 2 , "," ," ") . " DH" }} </td>
          <td> {{ number_format($ligneAchat->ttc , 2 , "," ," ") . " DH" }} </td>
        </tr>
      </tbody>
    </table>


    <footer>
        <table>
            <tbody>
                <tr>
                    <td> {{ $ligneAchat->entreprise->adresse ?? '' }} - {{ $ligneAchat->entreprise->ville ?? '' }} - Tél : {{ $ligneAchat->entreprise->telephone ?? '' }} </td>
                </tr>
                <tr>
                    <td>RC : {{ $ligneAchat->entreprise->rc ?? '' }} - N° : {{ $ligneAchat->entreprise->email ?? '' }} - Patente : {{ $ligneAchat->entreprise->patente ?? '' }} </td>
                </tr>
                <tr>
                    <td>ICE : {{ $ligneAchat->entreprise->ice ?? '' }} - email : {{ $ligneAchat->entreprise->email ?? '' }} / {{ $ligneAchat->entreprise->site ?? '' }} </td>
                </tr>
            </tbody>
        </table>
    </footer>



</body>
</html>


