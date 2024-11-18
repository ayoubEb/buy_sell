@extends('layouts.master')
@section('title')
    Liste des produits
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">liste des produits</h4>
      <div class="page-title-right">
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item active">liste des produits</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    @can("produit-nouveau")
      <a href="{{ route('produit.create') }}" class="btn btn-brown waves-effect waves-light mb-2">
        <span>
          Nouveau
        </span>
      </a>
    @endcan

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
                    <a href="{{ route('produit.edit',$produit) }}" class="btn btn-primary py-1 px-2 rounded-circle waves-effect waves-light">
                      <i class="mdi mdi-pencil-outline align-middle"></i>
                    </a>
                  @endcan
                  @can("produit-suppression")
                    <button type="button" class="btn btn-danger py-1 px-2 rounded-circle waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}">
                      <i class="mdi mdi-trash-can"></i>
                    </button>
                    <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <form action="{{ route('produit.destroy',$produit) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                              <h6 class="mb-2 fw-bolder text-center text-muted">
                                Voulez-vous vraiment déplacer du produit vers la corbeille
                              </h6>
                              <h6 class="text-danger mb-2 text-center">{{ $produit->designation }}</h6>
                              <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-vert waves-effect waves-light me-2 py-2 px-34">
                                  Je confirme
                                </button>
                                <button type="button" class="btn btn-orange waves-effect waves-light px-4" data-bs-dismiss="modal" aria-label="btn-close">
                                  Annuler
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  @endcan
                  @can("produit-display")
                    <a href="{{ route('produit.show',$produit) }}" class="btn btn-warning py-1 px-2 rounded-circle waves-effect waves-light">
                      <i class="mdi mdi-eye-outline align-middle" style="font-size: 0.90rem;"></i>
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

