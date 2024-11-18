@php
    $ligneAchat = \App\Models\LigneAchat::find($id);
@endphp
<div class="row row-cols-2">
  <div class="col">
    <div class="table-reponsive">
      <table class="table table-bordered m-0 info">
        <tbody>
          <tr>
            <td class="align-middle">référence</td>
            <td class="align-middle">
              <span class="">
                {{ $ligneAchat->num_achat}}
              </span>
            </td>
          </tr>
          <tr>
            <td class="align-middle">ht</td>
            <td class="align-middle">
              <span class="mt">
                {{ number_format($ligneAchat->ht , 2 , "," ," ") }} dh
              </span>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              ttc
            </td>
            <td class="align-middle">
              <span class="mt">
                {{ number_format($ligneAchat->ttc , 2 , "," ," ") }} dh
              </span>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span class="text-success">
                payer
              </span>
            </td>
            <td class="align-middle">
              <span class="mt text-success">
                {{ number_format($ligneAchat->payer , 2 , "," ," ") }} dh
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="col">
    <div class="table-reponsive">
      <table class="table table-bordered m-0 info">
        <tbody>
          <tr>
            <td class="align-middle">
              <span class="text-danger">
                reste
              </span>
            </td>
            <td class="align-middle">
              <span class="mt text-danger">
                {{ number_format($ligneAchat->reste , 2 , "," ," ") }} dh
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
              <span class="mt text-primary">
                {{ number_format($ligneAchat->net_payer , 2 , "," ," ") }} dh
              </span>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              tva
            </td>
            <td class="align-middle">
              <span class="fw-bold">
                {{ number_format($ligneAchat->taux_tva , 2 , "," ," ") }} %
              </span>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              fournisseur
            </td>
            <td class="align-middle">
              <span class="fw-bold">
                {{ $ligneAchat->fournisseur->raison_sociale }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


</div>