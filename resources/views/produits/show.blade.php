@extends('layouts.master')
@section('content')
<div class="card">
  <div class="card-body p-2">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h6 class="title m-0">
        produit : {{ $produit->reference }}
      </h6>
      <div class="">
          @can("produit-modification")
            <a href="{{ route('produit.edit',$produit) }}" class="btn btn-brown waves-effect waves-light px-3">
          <span class="mdi mdi-pencil-outline mdi-18px"></span>
            </a>
          @endcan
          @can("produit-suppression")
          <button type="button" class="btn btn-brown px-3 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{ $produit->id }}">
            <i class="mdi mdi-trash-can-outline mdi-18px"></i>
          </button>
          <div class="modal fade" id="delete{{ $produit->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
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
      </div>
    </div>

    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">information</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#stock" role="tab">stock</a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane p-3 active" id="info" role="tabpanel">
        <div class="row">
          <div class="col-lg-3">
            @if($produit->image != null)
            <img src="{{ asset('storage/images/produits/'.$produit->image ?? '') }}" alt="" class="img-fluid mb-2">
            @else
              <img src="{{ asset('images/produit_default.png') }}" alt="" class="w-100 mb-2">
            @endif
          </div>
          <div class="col">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">référence</td>
                    <td class="align-middle"> {{ $produit->reference }} </td>
                  </tr>
                  <tr>
                    <td class="align-middle">désignation</td>
                    <td class="align-middle"> {{ $produit->designation }} </td>
                  </tr>
                  <tr>
                    <td class="align-middle">prix achat</td>
                    <td class="align-middle"> {{ number_format($produit->prix_achat , 2 , ","," ") . ' dhs' }} </td>
                  </tr>
                  <tr>
                    <td class="align-middle">prix revient</td>
                    <td class="align-middle"> {{ number_format($produit->prix_revient , 2 , ","," ") . ' dhs' }} </td>
                  </tr>
                  <tr>
                    <td class="align-middle">date création</td>
                    <td class="align-middle"> {{ date("d/m/Y",strtotime($produit->created_at)) }} </td>
                  </tr>
                </tbody>
                @if ($produit->description != '')
                  <tfoot>
                    <tr>
                      <td class="align-middle" colspan="2">
                        {{ $produit->description ?? ''}}
                      </td>
                    </tr>
                  </tfoot>
                @endif
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane  p-3" id="stock" role="tabpanel">
        <div class="row row-cols-md-2 row-cols-1">
          <div class="col mb-md-0 mb-2">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      stock
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->num != '' ? $produit->stock->num : '' }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->date_stock != '' ? $produit->stock->date_stock : '' }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      sortie
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->sortie != '' ? $produit->stock->sortie : '' }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      min
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->min != '' ? $produit->stock->min : '' }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      max
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->max != '' ? $produit->stock->max : '' }}
                    </td>
                  </tr>


                </tbody>
              </table>
            </div>
          </div>
          <div class="col">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      initial
                    </td>
                    <td class="align-middle">
                      {{ $produit->stock && $produit->stock->initial != '' ? $produit->stock->initial : '' }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      quantité
                    </td>
                    <td class="align-middle">
                      {{ $produit->quantite }}
                    </td>
                  </tr>

                  <tr>
                    <td class="align-middle">
                      quantité augmenter
                    </td>
                    <td class="align-middle">
                      {{ $produit->qte_augmenter }}
                    </td>
                  </tr>


                    <tr>
                      <td class="align-middle">
                        quantité achats
                      </td>
                      <td class="align-middle">
                        {{ $produit->qte_achat }}
                      </td>
                    </tr>
                    <tr>
                      <td class="align-middle">
                        quantité achats réserver
                      </td>
                      <td class="align-middle">
                        {{ $produit->qte_achatRes }}
                      </td>
                    </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection