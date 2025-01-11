@extends('layouts.master')
@section('title')
Liste des stocks

@endsection
@section('content')
  <h6 class="title-header">
    liste des stocks
  </h6>
  <div class="card">
    <div class="card-body p-2">
      @include('layouts.session')
      <div class="table-responsive">
        <table class="table table-bordered table-customize m-0">
          <thead>
            <tr>
              <th>référence</th>
              <th>désignation</th>
              <th>quantite</th>
              <th>disponible</th>
              <th>sortie</th>
              <th>initial</th>
              <th>Reste</th>
              <th>min</th>
              <th>max</th>
              @canany(['stock-display', 'stock-modficiation', 'stock-suppression','stockHisorique-nouveau'])
                <th>opérations</th>
              @endcanany
            </tr>
          </thead>
          <tbody>
            @forelse ($produits as $produit)
              <tr>
                <td class="align-middle">
                    {{ $produit->reference ?? '' }}
                </td>
                <td class="align-middle">
                    {{ $produit->designation ?? '' }}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock  &&
                    $produit->stock->quantite != '' ?
                    $produit->stock->quantite : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock  &&
                    $produit->stock->disponible != '' ?
                    $produit->stock->disponible : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->sortie != '' ?
                    $produit->stock->sortie : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->initial != '' ?
                    $produit->stock->initial : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->reste != '' ?
                    $produit->stock->reste : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->min != '' ?
                    $produit->stock->min : 0
                  !!}
                </td>
                <td class="align-middle">
                  {!!
                    $produit->stock &&
                    $produit->stock->max != '' ?
                    $produit->stock->max : 0
                  !!}
                </td>
                @canany(['stock-display', 'stock-modficiation', 'stock-suppression','stockHisorique-nouveau'])
                  <td class="align-middle">
                    @if (!isset($produit->stock))
                      @can('stock-nouveau')
                        <a href="{{ route('stock.new',$produit) }}" class="btn btn-dark p-icon waves-effect waves-light">
                          <span class="mdi mdi-plus-thick align-middle"></span>
                        </a>
                      @endcan
                    @else
                      @can('stock-display')
                        <a href="{{ route('stock.show',$produit->stock->id) }}" class="btn btn-dark p-icon waves-effect waves-ligt">
                          <span class="mdi mdi-eye-outline align-middle"></span>
                        </a>
                      @endcan
                      @can('stock-modification')
                        <a href="{{ route('stock.edit',$produit->stock->id) }}" class="btn btn-primary p-icon waves-effect waves-ligt">
                          <span class="mdi mdi-pencil-outline align-middle"></span>
                        </a>
                      @endcan
                      @can('stockSuivi-nouveau')
                        <button type="button" class="btn btn-success waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#newAdd{{ $produit->id }}">
                          <span class="mdi mdi-plus-thick align-middle"></span>
                        </button>
                        <div class="modal fade" id="newAdd{{ $produit->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body p-3">
                                <h6 class="title text-center">
                                  augmenter
                                </h6>
                                <form action="{{ route('stockSuivi.store') }}" method="POST">
                                  @csrf
                                  <input type="hidden" name="stock" value="{{ $produit->stock->id }}">
                                  <div class="form-group mb-2">
                                    <label for="" class="form-label">Quantité</label>
                                    <input type="number" name="qte_add" id="" min="1" class="form-control" required>
                                  </div>
                                  @if (count($produit->depots) > 0)
                                    <div class="form-group mb-2">
                                      <label for="" class="form-label">depôt</label>
                                      <select name="depot_add" id="" class="form-select">
                                        <option value="">-- Séléctionner --</option>
                                        @foreach ($produit->depots as $dep_add)
                                          <option value="{{ $dep_add->id }}" {{ count($produit->depots) == 1 ? 'selected':'' }}> {{ $dep_add->num_depot }} </option>
                                        @endforeach
                                      </select>
                                    </div>
                                  @endif
                                  @if ($produit->check_default == true)
                                    <div class="form-group mb-2">
                                      <label for="" class="form-label">depot default</label>
                                      <input type="text" name="default_add" id="" class="form-control" value="{{ $produit->depot_default->num_depot }}">
                                    </div>
                                  @endif
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-vert waves-effect waves-light w-100">
                                        enregistrer
                                      </button>
                                    </div>
                                    <div class="col-6">
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

                        <button type="button" class="btn btn-danger waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#ruprute{{ $produit->id }}">
                            <i class="mdi mdi-minus"></i>
                        </button>
                        <div class="modal fade" id="ruprute{{ $produit->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body">
                                <h6 class="title text-center">
                                  démissionner
                                </h6>
                                <form action="{{ route('stockSuivi.resign',$produit->stock->id ?? '') }}" method="POST">
                                  @csrf
                                  <div class="form-group mb-2">
                                    <label for="" class="form-label">Quantié</label>
                                    <input type="number" name="qte_demi" id="" min="1" max="{{ $produit->reste }}" class="form-control" required>
                                  </div>
                                  @if (count($produit->depots) > 0)
                                    <div class="form-group mb-2">
                                      <label for="" class="form-label">depôt</label>
                                      <select name="depot_add" id="" class="form-select">
                                        <optio value="">-- Séléctionner --</optio  n>
                                        @foreach ($produit->depots as $dep_add)
                                          <option value="{{ $dep_add->id }}" {{ count($produit->depots) == 1 ? 'selected':'' }}> {{ $dep_add->num_depot }} </option>
                                        @endforeach
                                      </select>
                                    </div>
                                  @endif
                                  @if ($produit->check_default == true)
                                  <div class="form-group mb-2">
                                    <label for="" class="form-label">depot default</label>
                                    <input type="text" name="default_add" id="" class="form-control" value="{{ $produit->depot_default->num_depot }}">
                                  </div>
                                @endif
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-vert waves-effect waves-light w-100">
                                        Je confirme
                                      </button>
                                    </div>
                                    <div class="col-6">
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
            @empty
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="d-flex justify-content-center mt-2">
        {{ $produits->links() }}
      </div>
    </div>
  </div>







@endsection
