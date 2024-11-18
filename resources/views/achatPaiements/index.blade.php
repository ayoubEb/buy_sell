@extends('layouts.master')
@section('title')
    Liste des paiement achats
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">liste des paiements</h4>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    @include('layouts.session')
    <div class="table-responsive">
      <table class="table table-bordered table-customize m-0">
        <thead>
          <tr>
            <th>numéro opération</th>
            <th>référence</th>
            <th>fourinisseur</th>
            <th>type</th>
            <th>status</th>
            <th>montant payer</th>
            <th>date</th>
            @canany(['achatPaiement-modification', 'achatPaiement-suppression', 'achatPaiement-display'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse($achatPaiements as $k => $paiement)
            <tr>
              <td class="align-middle">
                {{
                  $paiement &&
                  $paiement->numero_operation != '' ?
                  $paiement->numero_operation : 'aucun'
                }}
              </td>
              <td class="align-middle"> {{ $paiement->ligne->num_achat ?? '' }} </td>
              <td class="align-middle">
                {{
                  $paiement &&
                  $paiement->ligne &&
                  $paiement->ligne->fournisseur &&
                  $paiement->ligne->fournisseur->raison_sociale != '' ?
                  $paiement->ligne->fournisseur->raison_sociale : 'aucun'
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
              <td class="align-middle text-success fw-bolder"> {{ $paiement->payer ?? 0 }} DH </td>
              <td class="align-middle"> {{ $paiement->date_paiement ?? '' }} </td>
              @canany(['achatPaiement-modification', 'achatPaiement-display', 'achatPaiement-suppression'])
                <td class="align-middle">
                  @can('achatPaiement-modification')
                    <a href="{{ route('achatPaiement.edit',$paiement) }}" class="btn btn-primary waves-effect waves-light px-2 p-0">
                      <span class="mdi mdi-pencil-outline align-middle"></span>
                    </a>
                  @endcan
                  @can('achatPaiement-display')
                    <a href="{{ route('achatPaiement.show',$paiement) }}" class="btn btn-warning waves-effect waves-light px-2 p-0">
                      <span class="mdi mdi-eye-outline align-middle"></span>
                    </a>
                  @endcan
                  @can('achatPaiement-suppression')
                    <button type="button" class="btn btn-danger waves-effect waves-light px-2 p-0" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}">
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
          @empty
            <tr>
              <td class="align-middle" @canany(['achatPaiement-modification', 'achatPaiement-display', 'achatPaiement-suppression']) colspan="8" @else colspan="7" @endcanany>
                <h6 class="text-center text-uppercase m-0 py-2">
                  aucun paiement
                </h6>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
