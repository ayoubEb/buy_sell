
@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="page-title mb-0 font-size-18">liste des catégories</h4>
          <div class="page-title-right">
              <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">liste des catégories</li>
              </ol>
          </div>
      </div>
  </div>
</div>
  <div class="card">
    <div class="card-body p-2">
      @include('layouts.session')
      @can('categorie-nouveau')
        <a href="{{ route('categorie.create') }}" class="btn btn-lien waves-effect waves-light mb-2">
          nouveau
        </a>
      @endcan
      <div class="table-responsive">
        <table class="table table-bordered mb-0 table-customize">
          <thead>
            <tr>
              <th>Nom</th>
              <th>description</th>
              @canany(['categorie-display', 'categorie-modification', 'categorie-suppression'])
                <th class="">actions</th>
              @endcanany
            </tr>
          </thead>
          <tbody>
            @forelse ($categories as $k => $categorie)
              <tr>
                <td class="align-middle">
                  {{ $categorie->nom }}
                </td>
                <td class="align-middle">
                  {!! Str::limit($categorie->description, 30, '...') ?? '<i class="text-muted">N/A</i>' !!}
                </td>
                @canany(['categorie-display', 'categorie-modification', 'categorie-suppression'])
                  <td class="align-middle">
                    @can('categorie-display')
                      <a href="{{ route('categorie.show',$categorie->id) }}" class="btn py-1 px-2 rounded-circle btn-warning waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="détail">
                        <span class="mdi mdi-eye-outline align-middle"></span>
                      </a>
                    @endcan
                    @can('categorie-modification')
                      <a href="{{ route('categorie.edit',$categorie->id) }}" class="btn py-1 px-2 rounded-circle btn-info waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modification">
                        <span class="mdi mdi-pencil-outline align-middle"></span>
                      </a>
                    @endcan
                    @can('categorie-suppression')
                      <button type="button" class="btn py-1 px-2 rounded-circle btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#destroy{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="suppression">
                        <span class="mdi mdi-trash-can"></span>
                      </button>
                      <div class="modal fade" id="destroy{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('categorie.destroy',$categorie->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                                <h6 class="mb-2 fw-bolder text-center text-muted">
                                    Voulez-vous vraiment déplacer du catégorie vers la corbeille
                                </h6>
                                <h6 class="text-danger mb-2 text-center">{{ $categorie->nom }}</h6>
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

            @empty
              <tr>
                <td colspan="3">
                  <h6 class="text-center m-0">
                    Aucun catégorie saisir
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
