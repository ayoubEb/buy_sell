@extends('layouts.master')
@section('content')
<div class="card">
  <div class="card-body p-3">

        <h6 class="title text-center">
          information de paiement
        </h6>
        <div class="row row-cols-2">
          <div class="col mb-3">
            <div class="table-reposnisve">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      fournisseur
                    </td>
                    <td class="align-middle">
                      {{ $fournisseur->raison_sociale }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      identifnat fournisseur
                    </td>
                    <td class="align-middle">
                      {{ $fournisseur->identifiant }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ice fournisseur
                    </td>
                    <td class="align-middle">
                      {{ $fournisseur->ice }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      type paiement
                    </td>
                    <td class="align-middle">
                      {{ $achatPaiement->type_paiement }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col mb-3">
            <div class="table-reposnisve">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      facture
                    </td>
                    <td class="align-middle">
                      {{ $ligneAchat->num_achat }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ttc
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($ligneAchat->ttc , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>

                  <tr>
                    <td class="align-middle">
                      montant payer
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($achatPaiement->payer , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant reste
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($ligneAchat->reste , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="row {{ $achatPaiement->type_paiement == 'chèque' ? "row-cols-2" : "row-cols-1" }}">
          @if ($achatPaiement->type_paiement == "chèque")
          <div class="col">
            <h6 class="title mb-2">
              info chèque
            </h6>
            <div class="table-responsive">
              <table class="table table-bordered info m-0">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      numéro
                    </td>
                    <td class="align-middle">
                      {{ $achatPaiement->cheque && $achatPaiement->cheque->numero != '' ? $achatPaiement->cheque->numero : ''}}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      banque
                    </td>
                    <td class="align-middle">
                      {{ $achatPaiement->cheque && $achatPaiement->cheque->banque != '' ? $achatPaiement->cheque->banque : ''}}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date
                    </td>
                    <td class="align-middle">
                      {{ $achatPaiement->cheque && $achatPaiement->cheque->date_cheque != '' ? $achatPaiement->cheque->date_cheque : ''}}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date enquisement
                    </td>
                    <td class="align-middle">
                      {{ $achatPaiement->cheque && $achatPaiement->cheque->date_enquisement != '' ? $achatPaiement->cheque->date_enquisement : ''}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          @endif
          <div class="col">
            <h6 class="title mb-2">
              résume
            </h6>
            <div class="table-responsive">
              <table class="table table-bordered info m-0">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      numéro
                    </td>
                    <td class="align-middle">
                      {{ $achatPaiement->num }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      numéro opération
                    </td>
                    <td class="align-middle">
                      {{ $achatPaiement->numero_operation }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date
                    </td>
                    <td class="align-middle">
                      {{ $achatPaiement->created_at }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant à payer
                    </td>
                    <td class="align-middle">
                      {{ number_format($achatPaiement->payer , 2 , "," ," ") }} dh
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

          </div>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-6">
            <div class="mt-2 bg-vert-light py-3 border-2 border-solid border-primary border-rounded">
              <h6 class="text-center m-0">
                Votre paiement a été accepter
              </h6>
            </div>
            <div class="row row-cols-2">
              <div class="col mb-2">
                <a href="{{ route('achatPaiement.index') }}" class="btn btn-orange waves-effect waves-light w-100 text-start">liste des paiements</a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('ligneAchat.show',$ligneAchat) }}" class="btn btn-orange waves-effect waves-light w-100 text-start">liste des paiement du cette ligneAchat</a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('achatPaiement.show',$achatPaiement) }}" class="btn btn-orange waves-effect waves-light w-100 text-start">display le reçu</a>
              </div>
              @if ($ligneAchat->reste != 0)
                <div class="col mb-2">
                  <a href="{{ route('achatPaiement.add',$ligneAchat->id) }}" class="btn btn-vert waves-effect waves-light w-100 text-start">autre paiement</a>
                </div>

              @endif
            </div>
          </div>

        </div>



  </div>
</div>
@endsection
