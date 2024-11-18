@extends('layouts.master')
@section('title')
    Liste des paiement du factures
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Acceuil</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Liste des paiement du factures

        </li>
    </ol>
</nav>

<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-sm m-0">
        <thead>
          <tr>
            <th>numéro opération</th>
            <th>référence</th>
            <th>client</th>
            <th>type</th>
            <th>status</th>
            <th>montant payer</th>
            <th>date</th>
            @canany(['achatPaiement-modification', 'achatPaiement-suppression', 'achatPaiement-display'])
              <th>actions</th>
            @endcanany
          </tr>
          <tbody>
            @foreach ($ventePaiements as $k => $paiement)
              <tr>
                <td class="align-middle">
                  {{
                      $paiement &&
                      $paiement->numero_operation != '' ?
                      $paiement->numero_operation : 'aucun'
                  }}
                </td>
                <td class="align-middle"> {{ $paiement->facture->num ?? '' }} </td>
                <td class="align-middle">
                  {{
                    $paiement->facture &&
                    $paiement->facture->client &&
                    $paiement->facture->client->raison_sociale != '' ?
                    $paiement->facture->client->raison_sociale : 'aucun'
                  }}
                </td>
                <td class="align-middle">
                  {{ $paiement->type_paiement ?? '' }}
                </td>
                <td class="align-middle">
                  {!!
                    $paiement->status == "payé" ? '<span class="mdi mdi-check-bold text-success"></span>' :'<span class="mdi mdi-close text-danger"></span>'
                  !!}
                </td>
                <td class="align-middle text-success fw-bolder text-uppercase"> {{ number_format($paiement->payer , 2 , "," ," ") }} dhs </td>
                <td class="align-middle"> {{ $paiement->date_paiement ?? '' }} </td>
                @canany(['ventePaiement-modification', 'ventePaiement-display', 'ventePaiement-suppression'])
                  <td class="align-middle">
                    {{-- <a href="{{ route('ventePaiement.recu',$paiement) }}" class="btn btn-dark waves-effect waves-light p-0 px-1 rounded-circle" target="_blank">
                      <span class="mdi mdi-file"></span>
                    </a> --}}
                    @can('ventePaiement-modification')
                      <a href="{{ route('ventePaiement.edit',$paiement) }}" class="btn btn-primary waves-effect waves-light px-1 p-0">
                        <span class="mdi mdi-pencil-outline"></span>
                      </a>
                    @endcan
                    @can('ventePaiement-display')
                      <a href="{{ route('ventePaiement.show',$paiement) }}" class="btn btn-warning waves-effect waves-light px-1 p-0">
                        <span class="mdi mdi-eye-outline"></span>
                      </a>
                    @endcan
                    @can('ventePaiement-suppression')
                      <button type="button" class="btn btn-danger waves-effect waves-light px-1 p-0" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}">
                        <span class="mdi mdi-trash-can"></span>
                      </button>
                      <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('achatPaiement.destroy',$paiement) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <h3 class="text-primary mb-3 textx-center">Confirmer la suppression</h3>
                                <h6 class="mb-2 fw-bolder text-center text-muted">
                                    Voulez-vous vraiment déplacer du paiement vers la corbeille
                                </h6>
                                <h6 class="text-danger mb-2 text-center">{{ $paiement->numero_operation }}</h6>
                                <div class="d-flex justify-content-center">
                                  <button type="submit" class="btn btn-primary px-5 fw-bolder py-2 me-2">
                                    Je confirme
                                  </button>
                                  <button type="button" class="btn btn-light px-5 py-2 fw-bolder" data-bs-dismiss="modal" aria-label="btn-close" style="background:#CEAD6D">
                                    Annuler
                                  </button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endcan
                  </td>
                @endcanany
              </tr>
            @endforeach
          </tbody>
        </thead>
      </table>
    </div>
  </div>
</div>

@endsection