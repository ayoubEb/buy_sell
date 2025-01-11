@extends('layouts.master')
@section('content')
<div class="d-md-flex justify-content-between mb-2">
  <h4 class="title-header">
    <a href="{{ route('stock.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    stock : {{ $stock->num }}
  </h4>

  @canany(['stockSuivi-nouveau', 'stock-modification','stockDepot-nouveau'])
  <div class="">
    @if ((count($stock->depots) - $count_depots ) != 0 )
      <a href="{{ route('stockDepot.add',$stock->id) }}" class="btn btn-brown waves-effect waves-light">
        <span class="mdi mdi-plus-outline align-middle"></span>
        nouveau depôts
      </a>
    @endif
      @can('stock-modification')
        <a href="{{ route('stock.edit',$stock) }}" class="btn btn-brown waves-effect waves-light">
          <span class="mdi mdi-pencil-outline align-middle"></span>
          modifier
        </a>
      @endcan
      @can('stockSuivi-nouveau')
        <button type="button" class="btn btn-brown waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#augmenter">
          <span class="mdi mdi-plus-thick align-middle"></span>
          <span>augemnter</span>
        </button>
        <div class="modal fade" id="augmenter" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body p-3">
                <h6 class="title text-center">
                  augmenter
                </h6>
                <form action="{{ route('stockSuivi.store',$stock->id) }}" method="POST">
                  @csrf
                  <input type="hidden" name="stock" value="{{ $stock->id }}">
                  <div class="form-group mb-2">
                    <label for="" class="form-label">Quantié</label>
                    <input type="number" name="qte_add" id="" min="1" class="form-control" required>
                  </div>
                  @if (count($depots) > 0)
                    <div class="form-group mb-2">
                      <label for="" class="form-label">depôt</label>
                      <select name="depot_add" id="" class="form-select">
                        <option value="">-- Séléctionner --</option>
                        @foreach ($depots as $dep_add)
                          <option value="{{ $dep_add->id }}" {{ count($depots) == 1 ? 'selected':'' }}> {{ $dep_add->num_depot }} </option>
                        @endforeach
                      </select>
                    </div>

                  @endif
                  @if ($check_default == true)
                    <div class="form-group mb-2">
                      <label for="" class="form-label">depot default</label>
                      <input type="text" name="default_add" id="" class="form-control" value="{{ $depot_default->num_depot }}">
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
        @if ($stock->reste == 0)
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
                  <form action="{{ route('stockSuivi.resign',$stock->id ?? '') }}" method="POST">
                    @csrf
                    <div class="form-group mb-2">
                      <label for="" class="form-label">Quantié</label>
                      <input type="number" name="qte_demi" id="" min="1" max="{{ $stock->disponible }}" class="form-control" required>
                    </div>
                    @if (count($depots) > 0)
                      <div class="form-group mb-2">
                        <label for="" class="form-label">depôt</label>
                        <select name="depot_add" id="" class="form-select">
                          <option value="">-- Séléctionner --</option>
                          @foreach ($depots as $dep_add)
                            <option value="{{ $dep_add->id }}" {{ count($depots) == 1 ? 'selected':'' }}> {{ $dep_add->num_depot }} </option>
                          @endforeach
                        </select>
                      </div>

                    @endif
                    @if ($check_default == true)
                      <div class="form-group mb-2">
                        <label for="" class="form-label">depot default</label>
                        <input type="text" name="default_add" id="" class="form-control" value="{{ $depot_default->num_depot }}">
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
        @endif
      @endcan
    </div>
  @endcanany
</div>
<div class="card">
  <div class="card-body p-2">
    @include('layouts.session')
    <ul class="nav nav-tabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#info" role="tab">information</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#suivi" role="tab">suivi</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#depots" role="tab">depots</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#history" role="tab">historique</a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane p-3 active" id="info" role="tabpanel">
        <div class="row row-cols-md-2 row-cols-1">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-borderless m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      <span>
                        numéro :
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->num }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        disponible
                      </span>
                    </td>
                    <td class="align-middle">
                      {{$stock->disponible }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        sortie
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->sortie }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        initial
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->initial }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        min
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->min }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        max
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->max }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        statut
                      </span>
                    </td>
                    <td class="align-middle">
                      @if ($stock->qte_alert < $stock->disponible)
                        <span class="text-success">
                          disponible
                        </span>
                      @elseif($stock->qte_alert < $stock->disponible)
                        <span class="text-warning">
                          En restant : {{ $stock->disponible - $stock->qte_alert }}
                        </span>
                      @else
                        <soan class="text-danger">
                          rupture
                        </soan>
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col">
            <div class="table-responsive">
              <table class="table table-borderless m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      <span>
                        produit
                      </span>
                    </td>
                    <td class="align-middle">
                      {{
                        $stock->produit &&
                        $stock->produit->reference != '' ?
                        $stock->produit->reference : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        date
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->date_stock }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        ventes
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->qte_vente }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        achats
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->qte_achat }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        ventes ( réserver )
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->qte_venteRes }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        achats ( réserver )
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->qte_achatRes }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        augmentations
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->qte_augmenter }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      <span>
                        alert
                      </span>
                    </td>
                    <td class="align-middle">
                      {{ $stock->qte_alert }}
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
          <table class="table table-bordered m-0 table-customize">
            <thead>
              <tr>
                <th>date</th>
                <th>quantite</th>
                <th>fonction</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($stockSuivis as $stockSuivi)
                <tr>
                  <td class="align-middle">
                    {{ $stockSuivi->date_suivi }}
                  </td>
                  <td class="align-middle">
                    {{ $stockSuivi->quantite }}
                  </td>
                  <td class="align-middle">
                    {{ $stockSuivi->fonction }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane p-3" id="depots" role="tabpanel">
        <div class="table-responsive">
          <table class="table table-bordered m-0 table-customize">
            <thead>
              <tr>
                <th>depot</th>
                <th>adresse</th>
                <th>quantite</th>
                <th>entre</th>
                <th>sortie</th>
                <th>disponible</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($depots as $depot)
                <tr>
                  <td class="align-middle">
                    {{ $depot->num_depot }}
                  </td>
                  <td class="align-middle">
                    {{ $depot->adresse }}
                  </td>
                  <td class="align-middle">
                    {{ $depot->pivot->quantite }}
                  </td>
                  <td class="align-middle">
                    {{ $depot->pivot->entre }}
                  </td>
                  <td class="align-middle">
                    {{ $depot->pivot->sortie }}
                  </td>
                  <td class="align-middle">
                    {{ $depot->pivot->disponible }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane p-3" id="history" role="tabpanel">
        <div class="table-repsonsive">
          <table class="table table-customize m-0">
            <thead>
              <tr>
                <th>actions</th>
                <th>utilisateur</th>
                <th>date</th>
                <th>temps</th>
                <th>valeurs</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($suivi_actions as $suivi)
                <tr>
                  <td class="align-middle">
                    @if ($suivi->event == "created")
                      <span class="bg-success px-2 py-1 rounded text-white fw-bold">
                          Nouveau
                      </span>
                    @elseif ($suivi->event == "deleted")
                      <span class="bg-danger px-2 py-1 rounded text-white fw-bold">
                          Suppression
                      </span>
                    @elseif ($suivi->event == "updated")
                      <span class="bg-primary px-2 py-1 rounded text-white fw-bold">
                          Modification
                      </span>
                    @endif
                  </td>
                  <td class="align-middle">
                    {{ $suivi->user }}
                  </td>
                  <td class="align-middle">
                    {{ date("d/m/Y",strtotime($suivi->created_at)) }}
                  </td>
                  <td class="align-middle">
                    {{ date("H:i:s",strtotime($suivi->created_at)) }}
                  </td>
                  <td class="align-middle">
                    <button type="button" class="btn btn-primary waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#display{{ $suivi->id }}">
                      <span class="mdi mdi-eye-outline"></span>
                    </button>
                    <div class="modal fade" tabindex="-1" id="display{{ $suivi->id }}" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                          </div>
                          <div class="modal-body p-2">
                            @php
                              $array_insert = [];
                              $array_sup = [];
                              if($suivi->event == "created" ){
                                foreach($suivi->properties['attributes'] ?? [] as $attribute => $value){
                                  if(!is_null($value)){
                                    $array_insert[] = [
                                      "champ"=>$attribute,
                                      "value"=>$value,
                                    ];
                                  }
                                }
                              }
                              elseif ($suivi->event == "deleted") {
                                foreach($suivi->properties['old'] ?? [] as $attribute => $value){
                                  if(!is_null($value)){
                                    $array_sup[] = [
                                      "champ"=>$attribute,
                                      "value"=>$value,
                                    ];
                                  }
                                }
                              }
                            @endphp
                            @php
                              $properties        = json_decode($suivi->properties, true);
                              $changedAttributes = [];
                              if (isset($properties['old']) && isset($properties['attributes'])) {
                                foreach ($properties['attributes'] as $key => $newValue) {
                                  if (isset($properties['old'][$key]) && $properties['old'][$key] != $newValue) {
                                    $changedAttributes[$key] = [
                                      'old' => $properties['old'][$key],
                                      'new' => $newValue
                                    ];
                                  }
                                }
                              }
                              // dd($properties);
                            @endphp
                            @if (count($changedAttributes) > 0)
                              @foreach($changedAttributes as $key => $values)
                                @if(count($changedAttributes) > 0)
                                  <ul class="list-group">
                                    <li class="list-group-item active text-center py-2">
                                      <b>{{ ucfirst($key) }}</b>
                                    </li>
                                    <li class="list-group-item text-center py-2">
                                      <div class="row row-cols-2">
                                        <div class="col">
                                          <h6>
                                            avant
                                          </h6>
                                        </div>
                                        <div class="col">
                                          <h6>
                                            nouveau
                                          </h6>
                                        </div>
                                      </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-evenly align-items-center py-2">
                                      @if(is_array($values['old']))
                                          @foreach($values['old'] as $oldValue)
                                              {{ $oldValue }}
                                            @endforeach
                                      @else
                                        {{ $values['old'] }}
                                      @endif
                                      <span class="mdi mdi-arrow-right-thick"></span>
                                      @if(is_array($values['new']))
                                      @foreach($values['new'] as $newValue)
                                          {{ $newValue }}
                                      @endforeach
                                        @else
                                          {{ $values['new'] }}
                                        @endif
                                    </li>
                                  </ul>

                                @else
                                  <small>No changes recorded</small>
                                @endif

                              @endforeach
                            @elseif($suivi->event == "created")
                            <h6 class="text-center title">
                              {{ $suivi->event }}
                            </h6>
                            <ul class="list-group">
                              @foreach ($array_insert as $attribute)

                                <li class="list-group-item">
                                  <strong>{{ $attribute['champ'] }} : </strong>
                                  {{ $attribute['value'] }}

                                </li>
                              @endforeach

                            </ul>
                            @elseif($suivi->event == "deleted")
                              <h6 class="text-center title">
                                {{ $suivi->event }}
                              </h6>
                              <ul class="list-group">
                                @foreach ($array_sup as $attribute)
                                  <li class="list-group-item">
                                    <strong>{{ $attribute['champ'] }} : </strong>
                                    {{ $attribute['value'] }}
                                  </li>
                                @endforeach
                              </ul>
                            @endif
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
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