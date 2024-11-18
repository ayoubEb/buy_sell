@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
  <div class="col-xxl-5">
    <div class="card">
      <div class="card-body p-2">
        <h6 class="text-center py-2 border border-info border-solid my-2 text-uppercase rounded border-2">
          reçu du paiement : {{ $facturePaiement->num }}
        </h6>
        <p class="text-center">
          Le date : {{ $facturePaiement->created_at }}
        </p>
        <table class="table table-borderless info m-0">
          <tbody>
            <tr>
              <td colspan="2" class="subTitle">
                <span>
                  client

                </span>
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                numéro du paiement :
              </td>
              <td class="align-middle">
                {{ $facturePaiement->numero_operation }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                date :
              </td>
              <td class="align-middle">
                {{ $facturePaiement->date_paiement }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                type :
              </td>
              <td class="align-middle">
                {{ $facturePaiement->type_paiement }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                statut :
              </td>
              <td class="align-middle">
                {{ $facturePaiement->status }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                montant payer :
              </td>
              <td class="align-middle">
                {{ number_format($facturePaiement->payer , 2 , ',' ,' ') }}
              </td>
            </tr>
            <tr>
              <td colspan="2" class="subTitle">
                <span>
                  basic information
                </span>
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                raison sociale :
              </td>
              <td class="align-middle">
                {{ $client->raison_sociale }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                ice :
              </td>
              <td class="align-middle">
                {{ $client->ice }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                identifant :
              </td>
              <td class="align-middle">
                {{ $client->identifiant }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                email :
              </td>
              <td class="align-middle">
                {{ $client->email }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                téléphone :
              </td>
              <td class="align-middle">
                {{ $client->telephone }}
              </td>
            </tr>
          </tbody>
        </table>


        <h6 class="bg-vert-light p-3 text-center">
          Votre paiement a été accepter
          <br>
          <span class="text-uppercase">
            numéro : {{ $facturePaiement->num }}

          </span>
        </h6>


        <div class="row justify-content-center mt-2">
          <div class="col-lg-8">
            <div class="row row-cols-2">
              <div class="col mb-2">
                <a href="{{ route('facturePaiement.minInfo',$facturePaiement) }}" class="btn btn-lien waves-effect waves-light w-100">
                  retour
                </a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('facturePaiement.index') }}" class="btn btn-lien waves-effect waves-light w-100">
                  liste
                </a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('facturePaiement.edit',$facturePaiement) }}" class="btn btn-lien waves-effect waves-light w-100">
                  modifier
                </a>
              </div>
              <div class="col">
                <a href="{{ route('facturePaiement.recu',$facturePaiement) }}" class="btn btn-doc waves-effect waves-light w-100" target="_blank">
                  imprimer le reçu
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


  </div>
</div>
@endsection