@extends('layouts.master')
@section('title')
  Liste des fournisseurs
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">Liste des fournisseurs</h4>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    @can('fournisseur-nouveau')
      <a href="{{ route('fournisseur.create') }}" class="btn btn-brown waves-effect waves-light mb-2">
        <span>nouveau</span>
      </a>
    @endcan
    <div class="table-responsive">
      <table class="table table-bordered m-0 table-customize">
        <thead class="table-success">
          <tr>
            <th>raison sociale</th>
            <th>rc</th>
            <th>ice</th>
            <th>téléphone</th>
            <th>fix</th>
            <th>email</th>
            <th>montant</th>
            <th>payer</th>
            <th>reste</th>
            @canany(['fournisseur-modification', 'fournisseur-display', 'fournisseur-suppression'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($fournisseurs as $fournisseur)
            <tr>
              <td class="align-middle">
                {!!
                  $fournisseur->raison_sociale != '' ?
                  $fournisseur->raison_sociale : '<span class="text-muted">N / A</span>'
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $fournisseur->rc != '' ?
                  $fournisseur->rc : '<span class="text-muted">N / A</span>'
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $fournisseur->ice != '' ?
                  $fournisseur->ice : '<span class="text-muted">N / A</span>'
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $fournisseur->telephone != '' ?
                  $fournisseur->telephone : '<span class="text-muted">N / A</span>'
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $fournisseur->fix != '' ?
                  $fournisseur->fix : '<span class="text-muted">N / A</span>'
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $fournisseur->email != '' ?
                  $fournisseur->email : '<span class="text-muted">N / A</span>'
                !!}
              </td>
              <td class="align-middle">
                <span class="fw-bold text-uppercase">
                  {{ number_format($fournisseur->montant , 2 , "," , " ") }} dhs
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-uppercase text-success">
                  {{ number_format($fournisseur->payer , 2 , "," , " ") }} dhs
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-uppercase text-danger">
                  {{ number_format($fournisseur->reste , 2 , "," , " ") }} dhs
                </span>
              </td>
              @canany(['fournisseur-display', 'fournisseur-modification', 'fournisseur-suppression'])
                <td class="align-middle">
                  @can('fournisseur-modification')
                    <a href="{{ route('fournisseur.edit',$fournisseur) }}" class="btn btn-primary py-1 px-2 rounded-circle waves-effect waves-light">
                      <i class="mdi mdi-pencil-outline align-middle"></i>
                    </a>
                  @endcan
                  @can('fournisseur-display')
                    <a href="{{ route('fournisseur.show',$fournisseur) }}" class="btn btn-warning py-1 px-2 rounded-circle waves-effect waves-light">
                      <i class="mdi mdi-eye-outline align-middle"></i>
                    </a>
                  @endcan
                  @can('fournisseur-suppression')
                    <button type="button" class="btn py-1 px-2 rounded-circle waves-effect waves-light btn-danger" data-bs-toggle="modal" data-bs-target="#delete{{ $fournisseur->id }}">
                      <i class="mdi mdi-trash-can" style="font-size: 0.90rem;"></i>
                    </button>
                    <div class="modal fade" id="delete{{ $fournisseur->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <form action="{{ route('fournisseur.destroy',$fournisseur) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                              <h6 class="mb-2 fw-bolder text-center text-muted">
                                Voulez-vous vraiment déplacer du fournisseur vers la corbeille
                              </h6>
                              <h6 class="text-danger mb-2 text-center">{{ $fournisseur->raison_sociale ?? '' }}</h6>
                              <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-vert waves-effect waves-light me-2">
                                  Je confirme
                                </button>
                                <button type="button" class="btn btn-orange waves-effect waves-light" data-bs-dismiss="modal" aria-label="btn-close">
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

          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>



@endsection
