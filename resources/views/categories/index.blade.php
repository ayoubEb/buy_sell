@extends('layouts.master')
@section('content')
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h6 class="title-header m-0">
      liste des catégories
    </h6>
    @can("categorie-nouveau")
      <a href="{{ route('categorie.create') }}" class="btn btn-brown waves-effect waves-light px-4">
        <span class="mdi mdi-plus-thick mdi-18px"></span>
      </a>
    @endcan
  </div>
  <div class="card">
    <div class="card-body p-2">
      @include('layouts.session')
      <div class="table-responsive">
        <table class="table table-bordered mb-0 table-customize">
          <thead>
            <tr>
              <th>Nom</th>
              <th>description</th>
              @canany(['categorie-modification', 'categorie-suppression'])
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
                @canany(['categorie-modification', 'categorie-suppression'])
                  <td class="align-middle">
                    @can('categorie-modification')
                      <a href="{{ route('categorie.edit',$categorie->id) }}" class="btn py-1 px-2 btn-info waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modification">
                        <span class="mdi mdi-pencil-outline align-middle"></span>
                      </a>
                    @endcan
                    @can('categorie-suppression')
                      <button type="button" class="btn py-1 px-2 btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#destroy{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="suppression">
                        <span class="mdi mdi-trash-can"></span>
                      </button>
                      <div class="modal fade" id="destroy{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('categorie.destroy',$categorie->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <div class="d-flex justify-content-center">
                                  <span class="mdi mdi-trash-can mdi-48px text-danger"></span>
                                </div>
                                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                                <h6 class="my-2 fw-bolder text-center text-muted">
                                    Voulez-vous vraiment suppression du catégorie ?
                                </h6>
                                <h6 class="text-danger mb-3 text-center">{{ $categorie->nom }}</h6>
                                <div class="row justify-content-center">
                                  <div class="col-lg-5">
                                    <button type="submit" class="btn btn-vert waves-effect waves-light fw-bolder py-2 w-100">
                                      Je confirme
                                    </button>
                                  </div>
                                  <div class="col-lg-5">
                                    <button type="button" class="btn btn-orange px-5 waves-effect waves-light" data-bs-dismiss="modal" aria-label="btn-close">
                                        Annuler
                                    </button>
                                  </div>
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
