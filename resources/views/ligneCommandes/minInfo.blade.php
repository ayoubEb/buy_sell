@php
    $commande = \App\Models\LigneVente::find($id);
@endphp
<h6 class="title mb-1">
  <span>base information</span>
</h6>
<div class="card">
  <div class="card-body p-2">
    <div class="row row-cols-2">
      <div class="col">
        <div class="table-reposnisve">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">
                  numéro
                </td>
                <td class="align-middle">
                  {{ $commande->num }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  client
                </td>
                <td class="align-middle">
                  {{
                    $commande->client &&
                    $commande->client->raison_sociale != '' ?
                    $commande->client->raison_sociale : ''
                  }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  téléphone
                </td>
                <td class="align-middle">
                  {{
                    $commande->client &&
                    $commande->client->phone != '' ?
                    $commande->client->phone : ''
                  }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  tva
                </td>
                <td class="align-middle">
                  {{ $commande->taux_tva }}%
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  date
                </td>
                <td class="align-middle">
                  {{ $commande->date_facture }}
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
      <div class="col">
        <div class="table-reposnisve">
          <table class="table table-bordered m-0 info">
            <tbody>

              <tr>
                <td class="align-middle">
                  prix ht
                </td>
                <td class="align-middle">
                  <span class="mt fw-bold">
                    {{ number_format($commande->ht , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  prix ttc
                </td>
                <td class="align-middle">
                  <span class="mt fw-bold">
                    {{ number_format($commande->ttc , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  <span class="text-primary">
                    net à payer
                  </span>
                </td>
                <td class="align-middle">
                  <span class="mt fw-bold text-primary">
                    {{ number_format($commande->net_payer , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  <span class="text-success">
                    payé
                  </span>
                </td>
                <td class="align-middle">
                  <span class="mt fw-bold text-success">
                    {{ number_format($commande->payer , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  <span class="text-danger">
                    reste
                  </span>
                </td>
                <td class="align-middle">
                  <span class="mt fw-bold text-danger">
                    {{ number_format($commande->reste , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

