<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/recu.css">
    <title>reçu du paiement espéce de client</title>
</head>
<body>
  <secton class="recu">
    <article class="topPage">
      <h6 class="title">
         reçu du paiement : {{ $facturePaiement->numero_operation ?? '' }}
      </h6>
      <div class="client">
        <table>
          <tbody>
            <tr>
              <td>raison sociale</td>
              <td>{{ $client->raison_sociale }} </td>
            </tr>
            <tr>
              <td>identifiant</td>
              <td> {{ $client->identifiant }} </td>
            </tr>
            <tr>
              <td>ice</td>
              <td> {{ $client->ice }} </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="facture">
        <table>
          <tbody>
            <tr>
              <td>numéro</td>
              <td>{{ $facture->num }} </td>
            </tr>
            <tr>
              <td>net à payer</td>
              <td> {{ number_format($facture->net_payer , 2 , "," ," ") }} dh </td>
            </tr>
            <tr>
              <td>reste</td>
              <td> {{ number_format($facture->reste , 2 , "," ," ") }} dh </td>
            </tr>
          </tbody>
        </table>
      </div>
    </article>

    <article>
      <table>
          <tbody>
            <tr>
                <td>numéro opération</td>
                <td> {{ $facturePaiement->numero_operation ?? '' }} </td>
            </tr>
            <tr>
                <td>mode</td>
                <td> {{ $facturePaiement->type_paiement ?? '' }} </td>
            </tr>
            <tr>
                <td>date</td>
                <td> {{ $facturePaiement->date_paiement ?? '' }} </td>
            </tr>
            <tr>
                <td>montant payer</td>
                <td> {{ $facturePaiement->payer ?? 0 }} DH </td>
            </tr>
            <tr>
                <td>numéro</td>
                <td> {{ $facture->num ?? '' }} </td>
            </tr>
          </tbody>
      </table>
    </article>

    @if ($facturePaiement->type_paiement == "chèque")
    <article class="infoCheque">
      <div>
        <table>
            <tbody>

              <tr>
                  <td>numéro</td>
                  <td> {{ $facturePaiement->cheque->numero ?? '' }} </td>
              </tr>

              <tr>
                  <td>date chèque</td>
                  <td> {{ $facturePaiement->cheque->date_cheque ?? '' }} </td>
              </tr>
            </tbody>
        </table>
      </div>
      <div>
        <table>
            <tbody>
              <tr>
                  <td>date enquisement</td>
                  <td> {{ $facturePaiement->cheque->date_enquisement ?? '' }} </td>
              </tr>
              <tr>
                  <td>banque</td>
                  <td> {{ $facturePaiement->cheque->bank->nom_bank ?? '' }} </td>
              </tr>



            </tbody>
        </table>
      </div>
    </article>
    @endif
</secton>





</body>
</html>