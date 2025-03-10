@extends('layouts.master')
@section('content')
<div class="card">
  <div class="card-body p-3">

        <h6 class="title text-center">
          information de paiement
        </h6>
        <div class="row row-cols-2">
          <div class="col">
            <div class="table-reposnisve">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      client
                    </td>
                    <td class="align-middle">
                      {{ $client->raison_sociale }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      identifnat client
                    </td>
                    <td class="align-middle">
                      {{ $client->identifiant }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ice client
                    </td>
                    <td class="align-middle">
                      {{ $client->ice }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      type paiement
                    </td>
                    <td class="align-middle">
                      {{ $ventePaiement->type_paiement }}
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
                      facture
                    </td>
                    <td class="align-middle">
                      {{ $commande->num }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      net à payer
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($commande->net_payer , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>

                  <tr>
                    <td class="align-middle">
                      montant payer reçu
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($ventePaiement->payer , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant reste
                    </td>
                    <td class="align-middle">
                      <span class="mt">
                        {{ number_format($commande->reste , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="row {{ $ventePaiement->type_paiement == 'chèque' ? "row-cols-2" : "row-cols-1" }}">
          @if ($ventePaiement->type_paiement == "chèque")
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
                      {{ $ventePaiement->cheque && $ventePaiement->cheque->numero != '' ? $ventePaiement->cheque->numero : ''}}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      banque
                    </td>
                    <td class="align-middle">
                      {{ $ventePaiement->cheque && $ventePaiement->cheque->banque != '' ? $ventePaiement->cheque->banque : ''}}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date
                    </td>
                    <td class="align-middle">
                      {{ $ventePaiement->cheque && $ventePaiement->cheque->date_cheque != '' ? $ventePaiement->cheque->date_cheque : ''}}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date enquisement
                    </td>
                    <td class="align-middle">
                      {{ $ventePaiement->cheque && $ventePaiement->cheque->date_enquisement != '' ? $ventePaiement->cheque->date_enquisement : ''}}
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
                      {{ $ventePaiement->num }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      numéro opération
                    </td>
                    <td class="align-middle">
                      {{ $ventePaiement->numero_operation }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date
                    </td>
                    <td class="align-middle">
                      {{ $ventePaiement->created_at }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant à payer
                    </td>
                    <td class="align-middle">
                      {{ number_format($ventePaiement->payer , 2 , "," ," ") }} dh
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
                <a href="{{ route('ventePaiement.index') }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">liste des paiements</a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('ligneVente.show',$commande) }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">liste des paiement du cette facture</a>
              </div>
              {{-- <div class="col mb-2">
                <a href="{{ route('ventePaiement.recu',$ventePaiement) }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">Imprimer le reçu</a>
              </div> --}}
              <div class="col mb-2">
                <a href="{{ route('ventePaiement.show',$ventePaiement) }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">display le reçu</a>
              </div>
              @if ($commande->reste != 0)
                <div class="col mb-2">
                  <a href="{{ route('ventePaiement.add',$commande->id) }}" class="btn btn-noBack waves-effect waves-light w-100 text-start">autre paiement</a>
                </div>

              @endif
            </div>
          </div>

        </div>



  </div>
</div>
@endsection