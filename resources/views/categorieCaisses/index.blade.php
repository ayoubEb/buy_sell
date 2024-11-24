@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">liste des catégories dépense</h4>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body p-2">
    <a href="{{ route('categorieCaisse.create') }}" class="btn btn-brown waves-effect waves-light mb-2">
      nouveau
    </a>
    @include('layouts.session')
    <div class="table-responsive">
      <table class="table table-bordered table-customize m-0">
        <thead>
          <tr>
            <th>nom</th>
            <th>description</th>
            <th>statut</th>
            @canany(['categorieCaisse-display', 'categorieCaisse-modification', 'categorieCaisse-suppression'])
            <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @foreach ($categorieCaisses as $k => $categorieCaisse)
            <tr>
              <td class="align-middle">
                {{ $categorieCaisse->nom }}
              </td>
              <td class="align-middle">
                {{ $categorieCaisse->description }}
              </td>
              <td class="align-middle">
                {!! $categorieCaisse->statut == 1 ? '<span class="mdi mdi-check-bold text-success mdi-24px"></span>' : '<span class="mdi mdi-close text-danger mdi-18px"></span>' !!}
              </td>
              @canany(['categorieCaisse-display', 'categorieCaisse-modification', 'categorieCaisse-suppression'])
              <td class="align-middle">
                @can('categorieCaisse-display')
                  <a href="{{ route('categorieCaisse.show',$categorieCaisse) }}" class="btn py-1 px-2 rounded-circle btn-warning waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="détail">
                    <span class="mdi mdi-eye-outline align-middle"></span>
                  </a>
                @endcan
                @can('categorieCaisse-modification')
                  <a href="{{ route('categorieCaisse.edit',$categorieCaisse) }}" class="btn py-1 px-2 rounded-circle btn-info waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modification">
                    <span class="mdi mdi-pencil-outline align-middle"></span>
                  </a>
                @endcan
                @can('categorieCaisse-suppression')
                  <button type="button" class="btn py-1 px-2 rounded-circle btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#destroy{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="suppression">
                    <span class="mdi mdi-trash-can"></span>
                  </button>
                  <div class="modal fade" id="destroy{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body">
                          <form action="{{ route('categorieCaisse.destroy',$categorieCaisse) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                            <h6 class="mb-2 fw-bolder text-center text-muted">
                                Voulez-vous vraiment suppression du catégorie
                            </h6>
                            <h6 class="text-danger mb-2 text-center">{{ $categorieCaisse->nom }}</h6>
                            <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-vert waves-effect waves-light fw-bolder py-2 me-2">
                                  Je confirme
                              </button>
                              <button type="button" class="btn btn-orange px-5 waves-effect waves-light" data-bs-dismiss="modal" aria-label="btn-close">
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
      </table>
    </div>
  </div>
</div>
@endsection