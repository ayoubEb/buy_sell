@extends('layouts.master')
@section('content')
<div class="row justify-content-center">
  <div class="col-xxl-5">
    <div class="card">
      <div class="card-body p-2">
        <h6 class="text-center py-2 border border-info border-solid my-2 text-uppercase rounded border-2">
          reçu du paiement : {{ $achatPaiement->num }}
        </h6>
        <p class="text-center">
          Le date : {{ $achatPaiement->created_at }}
        </p>
        <table class="table table-borderless info m-0">
          <tbody>
            <tr>
              <td colspan="2" class="bg-primary text-white">
                <span>
                  basic informations

                </span>
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                numéro du paiement :
              </td>
              <td class="align-middle">
                {{ $achatPaiement->numero_operation }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                date :
              </td>
              <td class="align-middle">
                {{ $achatPaiement->date_paiement }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                type :
              </td>
              <td class="align-middle">
                {{ $achatPaiement->type_paiement }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                statut :
              </td>
              <td class="align-middle">
                {{ $achatPaiement->status }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                montant payer :
              </td>
              <td class="align-middle">
                {{ number_format($achatPaiement->payer , 2 , ',' ,' ') }}
              </td>
            </tr>
            <tr>
              <td colspan="2" class="bg-primary text-white">
                <span>
                  fournisseur
                </span>
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                raison sociale :
              </td>
              <td class="align-middle">
                {{ $fournisseur->raison_sociale }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                ice :
              </td>
              <td class="align-middle">
                {{ $fournisseur->ice }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                identifant :
              </td>
              <td class="align-middle">
                {{ $fournisseur->identifiant }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                email :
              </td>
              <td class="align-middle">
                {{ $fournisseur->email }}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                téléphone :
              </td>
              <td class="align-middle">
                {{ $fournisseur->telephone }}
              </td>
            </tr>
          </tbody>
        </table>


        <h6 class="bg-vert-light p-3 text-center">
          Votre paiement a été accepter
          <br>
          <span class="text-uppercase">
            numéro : {{ $achatPaiement->num }}

          </span>
        </h6>


        <div class="row justify-content-center mt-2">
          <div class="col-lg-8">
            <div class="row row-cols-2">
              <div class="col mb-2">
                <a href="{{ route('achatPaiement.minInfo',$achatPaiement) }}" class="btn btn-lien waves-effect waves-light w-100">
                  retour
                </a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('achatPaiement.index') }}" class="btn btn-lien waves-effect waves-light w-100">
                  liste
                </a>
              </div>
              <div class="col mb-2">
                <a href="{{ route('achatPaiement.edit',$achatPaiement) }}" class="btn btn-lien waves-effect waves-light w-100">
                  modifier
                </a>
              </div>
              {{-- <div class="col">
                <a href="{{ route('achatPaiement.recu',$achatPaiement) }}" class="btn btn-doc waves-effect waves-light w-100" target="_blank">
                  imprimer le reçu
                </a>
              </div> --}}
            </div>

          </div>
        </div>
      </div>
    </div>


  </div>
</div>
@endsection