<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/bon_cmd.css">
  <title>devis</title>
</head>
<body>

  <header class="">
    <h5>
      bon commande : {{ $ligneAchat->num_achat }}
    </h5>
  </header>
  <div class="sub-header">
    <div class="infoFournisseur">
      <ul>
        <li> {{ $ligneAchat->fournisseur->raison_sociale }} </li>
        <li> {{ $ligneAchat->fournisseur->adresse }} </li>
        <li> {{ $ligneAchat->fournisseur->ville }} </li>
        <li class="last"> {{ $ligneAchat->fournisseur->telephone }} </li>
      </ul>
    </div>
    <div class="minEntreprise">
      <ul>
        <li>
          <span>
            numéro :
          </span>
          {{ $ligneAchat->num_achat }}
        </li>
        <li>
          <span class="fw-bold">
            date :
          </span>
          {{ $ligneAchat->date_achat }}
        </li>

      </ul>

    </div>
  </div>

  <div class="produits">
    <table>
        <thead>
            <tr>
                <th>référence</th>
                <th>designation</th>
                <th>qté</th>
                <th>p.u (h.t)</th>
                <th>remise %</th>
                <th>montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($achats as $achat)
                <tr>
                    <td>
                      {{ $achat->produit->reference ?? ''}}
                    </td>
                    <td> {{ $achat->produit->designation ?? ''}} </td>
                    <td> {{ $achat->quantite ?? ''}} </td>
                    <td> {{ number_format($achat->prix , 2 , "," , " ")." dhs"}} </td>
                    <td> {{ $achat->remise ?? ''}} </td>
                    <td> {{ number_format($achat->montant , 2 , "," , " ")." dhs"}} </td>
                </tr>

            @endforeach
            @for ($i = 1; $i <= 10 - count($achats); $i++)
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

  <div class="cmd">
    <table>
      <thead>
          <tr>
              <th>montant ht</th>
              <th>tva</th>
              <th>ttc</th>
              <th>montant tva</th>
              <th>remise %</th>
          </tr>
      </thead>
      <tbody>
        <tr>
            <td> {{ number_format($ligneAchat->ht , 2 , "," , " ")." dhs"}} </td>
            <td> {{ number_format($ligneAchat->taux_tva , 2 , "," , " ")." %"}} </td>
            <td> {{ number_format($ligneAchat->ttc , 2 , "," , " ")." dhs"}} </td>
            <td> {{ number_format($ligneAchat->ht_tva , 2 , "," , " ")." dhs"}} </td>
            <td> {{ number_format($ligneAchat->remise , 2 , "," , " ")." %"}} </td>
        </tr>
      </tbody>

  </table>
  </div>



    <footer>
        <table class="table">
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


