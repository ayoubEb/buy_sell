<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=devif-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="./css/rapport.css">
  <title>Rapport client : {{ $client->raison_sociale }}</title>
</head>
<body>
  <header class="headerRapport">
    <h5>
      rapport de client : {{ $client->raison_sociale }}
    </h5>
  </header>

  <article class="infoClient">
      <table>
        <tbody>
          <tr>
            <td>identifiant</td>
            <td> {{ $client->identifiant }} </td>
          </tr>
          <tr>
            <td>raison sociale</td>
            <td> {{ $client->raison_sociale }} </td>
          </tr>
          <tr>
            <td>groupe</td>
            <td> {{ $client->group->nom }} </td>
          </tr>
          <tr>
            <td>remise</td>
            <td> {{ $client->group->remise }} </td>
          </tr>
          <tr>
            <td>adresse</td>
            <td> {{ $client->adresse }} </td>
          </tr>
          <tr>
            <td>ville</td>
            <td> {{ $client->ville }} </td>
          </tr>
          <tr>
            <td>ice</td>
            <td> {{ $client->ice }} </td>
          </tr>
          <tr>
            <td>if</td>
            <td> {{ $client->if }} </td>
          </tr>

          <tr>
            <td>responsable</td>
            <td>
              {{ $client->responsable }}
            </td>
          </tr>
          <tr>
            <td>rc</td>
            <td>
              {{ $client->rc }}
            </td>
          </tr>
          <tr>
            <td>téléphone</td>
            <td>
              {{ $client->telephone }}
            </td>
          </tr>
          <tr>
            <td>activité</td>
            <td>
              {{ $client->activite }}
            </td>
          </tr>
          <tr>
            <td>code postal</td>
            <td>
              {{ $client->code_postal }}
            </td>
          </tr>
          <tr>
            <td>email</td>
            <td>
              {{ $client->email }}
            </td>
          </tr>
          <tr>
            <td>type</td>
            <td>
              {{ $client->type_client }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </article>

  <h6 class="sub-title">
    statistique
  </h6>
  <article class="statistiques">
    <table>
      <thead>
        <tr>
          <th>montant</th>
          <th>payer</th>
          <th>net à payer</th>
          <th>reste</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
            {{ number_format($ht , 2 , ","  , " ") }} dhs
          </td>
          <td>
            {{ number_format($payer , 2 , ","  , " ") }} dhs
          </td>
          <td>
            {{ number_format($net_payer , 2 , ","  , " ") }} dhs
          </td>
          <td>
            {{ number_format($reste , 2 , ","  , " ") }} dhs
          </td>
        </tr>
      </tbody>
    </table>
  </article>
  <h6 class="sub-title">
    les commandes
  </h6>
  <div class="cmd">
    <table>
      <thead>
        <tr>
          <th>date</th>
          <th>référence</th>
          <th>ht</th>
          <th>ttc</th>
          <th>net à payer</th>
          <th>payer</th>
          <th>reste</th>
          <th>status</th>
          <th>date paiement</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($commandes as $commande)
          <tr>
            <td> {{ $commande->date_facture }} </td>
            <td> {{ $commande->num }} </td>
            <td> {{ number_format($commande->ht , 2 , "," ," ") }} dhs </td>
            <td> {{ number_format($commande->ttc , 2 , "," ," ") }} dhs </td>
            <td> {{ number_format($commande->net_payer , 2 , "," ," ") }} dhs </td>
            <td> {{ number_format($commande->payer , 2 , "," ," ") }} dhs </td>
            <td> {{ number_format($commande->reste , 2 , "," ," ") }} dhs </td>
            <td> {{ $commande->status }} </td>
            <td> {{ $commande->datePaiement }} </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  @if (count($paiements) > 0)
    <div class="paiements">
      <h6 class="title">
        les paiements
      </h6>
      <table>
        <thead>
          <tr>
            <th>facture</th>
            <th>numéro opération</th>
            <th>type</th>
            <th>date</th>
            <th>montant</th>
            <th>status</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($paiements as $paiement)
            <tr>
              <td>
                {{ $paiement->facture->num }}
              </td>
              <td>
                {{ $paiement->numero_operation }}
              </td>
              <td>
                {{ $paiement->type_paiement }}
              </td>
              <td>
                {{ $paiement->date_paiement }}
              </td>
              <td>
                {{ $paiement->payer }}
              </td>
              <td>
                {{ $paiement->status }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  @endif

  @if (count($commande_retards) > 0)
  <h6 class="sub-title">
    les commandes a été paiement en retard
  </h6>
    <article>
      <table>
        <thead>
          <tr>
            <th>numéro</th>
            <th>net à payer</th>
            <th>payer</th>
            <th>reste</th>
            <th>date paiements</th>
            <th>nombre jours de retard</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($commande_retards as $commande_retard)
            <tr>
              <td>
                {{ $commande_retard->num }}
              </td>
              <td>
                {{ number_format($commande_retard->net_payer , 2 , "," ," ") }} dh
              </td>
              <td>
                {{ number_format($commande_retard->payer , 2 , "," ," ") }} dh
              </td>
              <td>
                {{ number_format($commande_retard->reste , 2 , "," ," ") }} dh
              </td>
              <td>
                {{ $commande_retard->datePaiement }}
              </td>
              <td>
                {{ $commande_retard->nbr_days }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </article>
  @endif

  @if (count($commande_livraisons) > 0)
    <h6 class="sub-title">
      les commandes livraisons
    </h6>
    <table>
      <thead>
        <tr>
          <th>référence</th>
          <th>adresse</th>
          <th>ville</th>
          <th>montant</th>
          <th>date</th>
          <th>status</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($commande_livraisons as $cmd_livraison)
          <tr>
            <td>
              {{ $cmd_livraison->num }}
            </td>
            <td>
              {{ $cmd_livraison->adresse_livraison->adresse }}
            </td>
            <td>
              {{ $cmd_livraison->adresse_livraison->livraison->ville }}
            </td>
            <td>
              {{ number_format($cmd_livraison->adresse_livraison->montant , 2 , "," ," ") }} dh
            </td>
            <td>
              {{ $cmd_livraison->adresse_livraison->date_livraison }}
            </td>
            <td>
              {{ $cmd_livraison->adresse_livraison->statut_livraison }}
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
</body>
</html>