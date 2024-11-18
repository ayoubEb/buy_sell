@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="page-title mb-0 font-size-18">stock : {{ $stock->num }} </h4>

          <div class="page-title-right">
              <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">stock : {{ $stock->num }} </li>
              </ol>
          </div>

      </div>
  </div>
</div>


<div class="d-flex justify-content-between mb-2">
  <a href="{{ route('stock.index') }}" class="btn btn-orange waves-effect waves-light">
    retour
  </a>
  @canany(['stockSuivi-nouveau', 'stock-modification'])
    <div class="">
      @can('stock-modification')
        <a href="{{ route('stock.edit',$stock) }}" class="btn btn-brown waves-effect waves-light">
          <span class="mdi mdi-pencil-outline align-middle align-middle"></span>
          modifier
        </a>
      @endcan
      @can('stockSuivi-nouveau')
      <button type="button" class="btn btn-brown waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#augmenter">
        <span class="mdi mdi-plus-thick align-middle align-middle"></span>
        <span>augemnter</span>
      </button>
      <div class="modal fade" id="augmenter" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body p-3">
              <h6 class="title text-center">
                augmenter
              </h6>
              <form action="{{ route('stockSuivi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="stock" value="{{ $stock->id }}">
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

      <button type="button" class="btn btn-brown waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#resign">
        <span class="mdi mdi-minus align-middle"></span>
        <span>demissionner</span>
      </button>
      <div class="modal fade" id="resign" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
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
                  <input type="number" name="qte_demi" id="" min="1" max="{{ $stock->produit->reste }}" class="form-control" required>
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
    </div>
  @endcanany
</div>
<div class="card">
  <div class="card-body p-2">

    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">information</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#suivi" role="tab">suivi</a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane p-3 active" id="info" role="tabpanel">

        <div class="row row-cols-2">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-bordered table-customize m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle bg-gray-light">
                      référence
                    </td>
                    <td class="align-middle">
                      {{ $stock->produit->reference }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle bg-gray-light">
                      numéro
                    </td>
                    <td class="align-middle">
                      {{ $stock->num }}
                    </td>
                  </tr>

                  <tr>
                    <td class="align-middle">
                      reste
                    </td>
                    <td class="align-middle">
                      {{ $stock->produit->reste }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      initial
                    </td>
                    <td class="align-middle">
                      {{ $stock->initial }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      min
                    </td>
                    <td class="align-middle">
                      {{ $stock->min }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      max
                    </td>
                    <td class="align-middle">
                      {{ $stock->max }}
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
                      date
                    </td>
                    <td class="align-middle">
                      {{ $stock->date_stock }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ventes
                    </td>
                    <td class="align-middle">
                      {{
                        $stock->produit &&
                        $stock->produit->qte_vente != '' ?
                        $stock->produit->qte_vente : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      achats
                    </td>
                    <td class="align-middle">
                      {{
                        $stock->produit &&
                        $stock->produit->qte_achat != '' ?
                        $stock->produit->qte_achat : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      augmentations
                    </td>
                    <td class="align-middle">
                      {{
                        $stock->produit &&
                        $stock->produit->qte_augmenter != '' ?
                        $stock->produit->qte_augmenter : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      quantite
                    </td>
                    <td class="align-middle">
                      {{
                        $stock->produit &&
                        $stock->produit->quantite != '' ?
                        $stock->produit->quantite : ''
                      }}
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <div class="tab-pane p-3" id="suivi" role="tabpanel">

        <div class="table-responsive">
          <table class="table table-bordered m-0 table-sm">
            <thead>
              <tr>
                <th>date</th>
                <th>quantite</th>
                <th>fonction</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($stockHistoriques as $stockHistorique)
                <tr>
                  <td class="align-middle">
                    {{ $stockHistorique->date_mouvement }}
                  </td>
                  <td class="align-middle">
                    {{ $stockHistorique->quantite }}
                  </td>
                  <td class="align-middle">
                    {{ $stockHistorique->fonction }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>



@endsection