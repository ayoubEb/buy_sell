@extends('layouts.master')
@section('title')
    Liste des produits
@endsection
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h6 class="title-header m-0">
    liste des produits
  </h6>
  @can("produit-nouveau")
    <a href="{{ route('produit.create') }}" class="btn btn-brown waves-effect waves-light px-4">
      <span class="mdi mdi-plus-thick mdi-18px"></span>
    </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-1">
    @include('layouts.session')
    <div class="table-responsive">
      <table id="datatable" class="table table-bordered mb-0 table-customize">
        <thead>
          <tr>
            <th>Référrence</th>
            <th>Désignation</th>
            <th>P.d'achat</th>
            <th>P.revients</th>
            <th>Quantite</th>
            @canany(['produit-display', 'produit-modification', 'produit-suppression'])
              <th>Actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($produits as $k => $produit)
            <tr>
              <td class="align-middle">
                {{ $produit->reference ?? '' }}
              </td>
              <td class="align-middle">{{ $produit->designation }}</td>
              <td class="align-middle fw-bold fs-small">
                {{ number_format($produit->prix_achat , 2 , ',' , ' ') . ' DHS' }}
              </td>
              <td class="align-middle fw-bold fs-small">
                {{ number_format($produit->prix_revient , 2 , ',' , ' ') . ' DHS' }}
              </td>
              <td class="align-middle">
                <span @class([
                  'badge',
                  'bg-danger' => $produit->quantite == 0,
                  'bg-success' => $produit->quantite != 0,
                ])>
                  {{ $produit->quantite ?? '0' }}
                </span>

              </td>
              @canany(['produit-display', 'produit-modification', 'produit-suppression'])
                <td class="align-middle">
                  @can('produit-display')
                    <a href="{{ route('produit.edit',$produit) }}" class="btn btn-primary py-1 px-2 waves-effect waves-light">
                      <i class="mdi mdi-pencil-outline"></i>
                    </a>
                  @endcan
                  @can("produit-suppression")
                    <button type="button" class="btn btn-danger py-1 px-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}">
                      <i class="mdi mdi-trash-can"></i>
                    </button>
                    <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="d-flex justify-content-center">
                              <span class="mdi mdi-trash-can-outline mdi-48px text-danger"></span>
                            </div>
                            <form action="{{ route('produit.destroy',$produit) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                              <h6 class="fw-bolder text-center text-muted">
                                Voulez-vous vraiment déplacer du produit vers la corbeille
                              </h6>
                              <h6 class="text-danger my-3 text-center">{{ $produit->designation }}</h6>
                              <div class="row justify-content-center">
                                <div class="col-lg-5">
                                  <button type="submit" class="btn btn-vert waves-effect waves-light me-2 py-2 w-100">
                                    Je confirme
                                  </button>
                                </div>
                                <div class="col-lg-5">
                                  <button type="button" class="btn btn-orange waves-effect waves-light px-4 w-100" data-bs-dismiss="modal" aria-label="btn-close">
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
                  @can("produit-display")
                    <a href="{{ route('produit.show',$produit) }}" class="btn btn-warning py-1 px-2 waves-effect waves-light">
                      <span class="mdi mdi-eye-outline"></span>
                    </a>
                  @endcan
                </td>
              @endcanany
            </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <h6 class="text-center m-0">
                                    Aucun produit saisir
                                </h6>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>






@endsection

