@php
    $ligneAchat = \App\Models\LigneAchat::find($id)
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
                  {{ $ligneAchat->num_achat }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  fournisseur
                </td>
                <td class="align-middle">
                  {{
                    $ligneAchat->fournisseur &&
                    $ligneAchat->fournisseur->raison_sociale != '' ?
                    $ligneAchat->fournisseur->raison_sociale : ''
                  }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  téléphone
                </td>
                <td class="align-middle">
                  {{
                    $ligneAchat->fournisseur &&
                    $ligneAchat->fournisseur->phone != '' ?
                    $ligneAchat->fournisseur->phone : ''
                  }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  tva
                </td>
                <td class="align-middle">
                  {{ $ligneAchat->taux_tva }}%
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  <span class="text-success">
                    payer
                  </span>
                </td>
                <td class="align-middle">
                  <span class="mt fw-bold text-success">
                    {{ number_format($ligneAchat->payer , 2 , "," ," ") }} dhs
                  </span>
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
                  mois
                </td>
                <td class="align-middle">
                  {{ $ligneAchat->mois }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  prix ht
                </td>
                <td class="align-middle">
                  <span id="ht">
                    {{ number_format($ligneAchat->ht , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  ttc
                </td>
                <td class="align-middle">
                  <span id="ttc">
                    {{ number_format($ligneAchat->ttc , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  date
                </td>
                <td class="align-middle">
                  {{ $ligneAchat->date_achat }}
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
                    {{ number_format($ligneAchat->reste , 2 , "," , " ") }} dhs
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