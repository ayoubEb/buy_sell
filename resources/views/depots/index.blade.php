@extends('layouts.master')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title-header">
    liste des depôts
  </h4>
  <div class="">
    @can('depot-nouveau')
    <a href="{{ route('depot.create') }}" class="btn btn-brown px-4 waves-effect waves-light">
      <span class="mdi mdi-plus-thick"></span>
    </a>
    @endcan
    <a href="{{ route('depot.example') }}" class="btn btn-brown px-4 waves-effect waves-light">
      example
    </a>
    <button type="button" class="btn btn-darkLight waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#import"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="suppression">
      importer
     </button>
     <div class="modal fade" id="import" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-md modal-dialog-centered">
         <div class="modal-content">
           <div class="modal-body p-3">
             <form action="{{ route('depot.importer') }}" method="POST" enctype="multipart/form-data">
               @csrf
               <h6 class="title text-center mb-2">
                 importaiton fiche excel
               </h6>
               <div class="form-group mb-2">
                 <label for="" class="form-label">
                   fiche excel
                 </label>
                 <input type="file" name="file" class="form-control" id="">

               </div>
               <div class="row justify-content-center">
                 <div class="col-6">
                   <button type="submit" class="btn btn-vert waves-effect waves-light fw-bolder py-2 w-100">
                     Je confirme
                   </button>
                 </div>
                 <div class="col-6">
                   <button type="button" class="btn btn-orange px-5 waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                       Annuler
                   </button>
                 </div>
               </div>
             </form>
           </div>
         </div>
       </div>
     </div>
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responisive">
      <table class="table table-bordered table-customize m-0">
        <thead>
          <tr>
            <th>num</th>
            <th>adresse</th>
            <th>quantite</th>
            <th>disponible</th>
            <th>entre</th>
            <th>sortie</th>
            <th>statut</th>
            @canany(['depot-display', 'depot-modification', 'depot-suppression'])
            <th>opérations</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @foreach ($depots as $k =>  $depot)
            <tr>
              <td class="align-middle">
                {{ $depot->num_depot }}
              </td>
              <td class="align-middle">
                {{ $depot->adresse }}
              </td>
              <td class="align-middle">
                {{ $depot->quantite }}
              </td>
              <td class="align-middle">
                {{ $depot->disponible }}
              </td>
              <td class="align-middle">
                {{ $depot->entre }}
              </td>
              <td class="align-middle">
                {{ $depot->sortie }}
              </td>
              <td class="align-middle">
                {!! $depot->statut == 1 ? '<i class="mdi mdi-check-bold text-success"></i>' : '<i class="mdi mdi-close-thick text-danger"><i/>' !!}
              </td>
              @canany(['depot-display', 'depot-modification', 'depot-suppression'])
              <td class="align-middle">

                @can('depot-display')
                  <a href="{{ route('depot.show',$depot) }}" class="btn p-icon btn-dark waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="détail">
                    <span class="mdi mdi-eye-outline"></span>
                  </a>
                @endcan
                @can('depot-modification')
                  <a href="{{ route('depot.edit',$depot) }}" class="btn p-icon btn-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modification">
                    <span class="mdi mdi-pencil-outline"></span>
                  </a>
                @endcan
                @if ($depot->disponible > 0 && count($depot->stocks) > 0 )
                  @can('depot-modification')
                    @if ($depot->statut == 1)
                      <button type="button" class="btn btn-outline-danger p-icon waves-effect waves-light shadow-none" data-bs-toggle="modal" data-bs-target="#inactive{{ $k }}">
                        <span class="mdi mdi-close-thick "></span>
                      </button>
                      <div class="modal fade" id="inactive{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('depot.inactive',$depot) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="d-flex justify-content-center">
                                  <span class="mdi mdi-close-thick mdi-48px text-danger"></span>
                                </div>
                                <h6 class="mb-2 fw-bolder text-center">
                                  Êtes-vous sûr de vouloir inactive de depôt pour tous les stocks ?
                                </h6>
                                <h6 class="mb-2 text-center"><span class="text-uppercase text-danger">N.B&nbsp;:&nbsp;</span>le quantite de stock a été démissionner la disponible de stock</h6>
                                <div class="row justify-content-center">
                                  <div class="col-6">
                                    <button type="submit" class="btn btn-vert waves-efect waves-light w-100">
                                      <span class="mdi mdi-check-bold align-middle"></span>
                                      <span>
                                        Je confirme
                                      </span>
                                    </button>
                                  </div>
                                  <div class="col-6">
                                    <button type="button" class="btn btn-orange waves-effect wave-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                      <span class="mdi mdi-close align-middle"></span>
                                      Annuler
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    @else
                      <button type="button" class="btn btn-outline-success p-icon waves-effect waves-light shadow-none" data-bs-toggle="modal" data-bs-target="#active{{ $k }}">
                        <span class="mdi mdi-check-bold "></span>
                      </button>
                      <div class="modal fade" id="active{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('depot.active',$depot) }}" method="POST">
                                @csrf
                                @method("PUT")
                                <div class="d-flex justify-content-center">
                                  <span class="mdi mdi-check-bold mdi-48px text-success"></span>
                                </div>
                                <h6 class="mb-2 fw-bolder text-center">
                                  Êtes-vous sûr de vouloir active de depôt  pour tout les stocks ?
                                </h6>
                                <h6 class="mb-2 text-center"><span class="text-danger">N.B&nbsp;:&nbsp;</span>le quantite de stock a été augmenter la disponible de stock</h6>
                                <h6 class="text-primary mb-2 text-center">{{ $produit->reference ?? '' }}</h6>
                                <div class="row justify-content-center">
                                  <div class="col-6">
                                    <button type="submit" class="btn btn-vert waves-efect waves-light w-100">
                                      <span class="mdi mdi-check-bold align-middle"></span>
                                      <span>
                                        Je confirme
                                      </span>
                                    </button>
                                  </div>
                                  <div class="col-6">
                                    <button type="button" class="btn btn-orange waves-effect wave-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                      <span class="mdi mdi-close align-middle"></span>
                                      Annuler
                                    </button>
                                  </div>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif
                  @endcan
                @else

                  @can('depot-suppression')
                    <button type="button" class="btn p-icon btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#destroy{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="suppression">
                      <span class="mdi mdi-trash-can-outline"></span>
                    </button>
                    <div class="modal fade" id="destroy{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="d-flex justify-content-center">
                              <span class="mdi mdi-trash-can text-danger mdi-48px"></span>
                            </div>
                            <form action="{{ route('depot.destroy',$depot) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <h4 class="text-danger mb-3 text-center">Confirmer la suppression</h4>
                              <h6 class="mb-2 fw-bolder text-center">
                                  Voulez-vous vraiment suppression du catégorie ?
                              </h6>
                              <h6 class="text-primary mb-2 text-center">{{ $depot->nom }}</h6>
                              <div class="row justify-content-center">
                                <div class="col">
                                  <button type="submit" class="btn btn-vert waves-effect waves-light w-100">
                                    Je confirme
                                  </button>
                                </div>
                                <div class="col">
                                  <button type="button" class="btn btn-orange waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
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
                @endif

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