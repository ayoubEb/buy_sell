@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="page-title mb-0 font-size-18">produit : {{ $produit->reference }} </h4>
      </div>
  </div>
</div>

<div class="card">
  <div class="card-body p-2">
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