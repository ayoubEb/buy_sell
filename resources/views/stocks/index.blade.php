@extends('layouts.master')
@section('title')
Liste des stocks

@endsection
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">liste des stocks</h4>
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active">liste des stocks</li>
          </ol>
        </div>
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
              <th>référence</th>
              <th>désignation</th>
              <th>quantite</th>
              <th>sortie</th>
              <th>initial</th>
              <th>Reste</th>
              <th>min</th>
              <th>max</th>
              @canany(['stock-display', 'stock-modficiation', 'stock-suppression','stockHisorique-nouveau'])
                <th>actions</th>
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
                    $produit->quantite != '' ?
                    $produit->quantite : 0
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
                        <a href="{{ route('stock.new',$produit) }}" class="btn btn-dark py-1 px-2 rounded-circle waves-effect waves-light">
                          <i class="mdi mdi-plus-thick align-middle"></i>
                        </a>
                      @endcan
                    @else
                      @can('stock-display')
                        <a href="{{ route('stock.show',$produit->stock->id) }}" class="btn btn-warning py-1 px-2 rounded-circle waves-effect waves-ligt">
                          <i class="mdi mdi-eye-outline align-middle"></i>
                        </a>
                      @endcan
                      @can('stock-modification')
                        <a href="{{ route('stock.edit',$produit->stock->id) }}" class="btn btn-primary py-1 px-2 rounded-circle waves-effect waves-ligt">
                          <i class="mdi mdi-pencil-outline align-middle"></i>
                        </a>
                      @endcan
                      @can('stockSuivi-nouveau')
                        <button type="button" class="btn btn-success waves-effect waves-light py-1 px-2 rounded-circle" data-bs-toggle="modal" data-bs-target="#newAdd{{ $produit->id }}">
                          <i class="mdi mdi-plus-thick align-middle"></i>
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
                                    <label for="" class="form-label">Quantié</label>
                                    <input type="number" name="qte_add" id="" min="1" class="form-control" required>
                                  </div>
                                  <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-vert waves-effect waves-light me-2">
                                      enregistrer
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

                        <button type="button" class="btn btn-danger waves-effect waves-light py-1 px-2 rounded-circle" data-bs-toggle="modal" data-bs-target="#ruprute{{ $produit->id }}">
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
