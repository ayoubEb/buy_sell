@extends('layouts.master')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h6 class="title-header m-0">
    <a href="{{ route('depot.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    depot : {{ $depot->num_depot }}
  </h6>
  @can("depot-modification")
    <a href="{{ route('depot.edit',$depot) }}" class="btn btn-darkLight waves-effect waves-light px-3">
      <span class="mdi mdi-pencil-outline align-middle"></span>
      <span>modification</span>
    </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <h5 class="title">
      basic information
    </h5>
    <div class="row row-cols-2">
      <div class="col">
        <div class="table-responsive">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">
                  numéro ou nom
                </td>
                <td class="align-middle">
                  {{ $depot->num_depot }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  adresse
                </td>
                <td class="align-middle">
                  {{ $depot->adresse }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  quantite
                </td>
                <td class="align-middle">
                  {{ $depot->quantite }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="col">
        <div class="table-responisve">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">
                  disponible
                </td>
                <td class="align-middle">
                  {{ $depot->disponible }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  entre
                </td>
                <td class="align-middle">
                  {{ $depot->entre }}
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  sortie
                </td>
                <td class="align-middle">
                  {{ $depot->sortie }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <h5 class="title mt-2">
      stock & suivi
    </h5>
    <ul class="nav nav-tabs mt-2" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-bs-toggle="tab" href="#stocks" role="tab">stocks</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="tab" href="#history" role="tab">historique</a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane p-3 active" id="stocks" role="tabpanel">
        <div class="table-responsive">
          <table class="table table-bordered m-0 table-customize">
            <thead>
              <tr>
                <th>référence</th>
                <th>produit</th>
                <th>numéro</th>
                <th>disponible</th>
                <th>achat</th>
                <th>vente</th>
                <th>achat réserver</th>
                <th>vente réserver</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($stock_depots as $stock_depot)
                <tr>

                  <td class="align-middle">
                    {{
                      $stock_depot->produit &&
                      $stock_depot->produit->reference != '' ?
                      $stock_depot->produit->reference : ''
                    }}
                  </td>
                  <td class="align-middle">
                    {{
                      $stock_depot->produit &&
                      $stock_depot->produit->designation != '' ?
                      $stock_depot->produit->designation : ''
                    }}
                  </td>
                  <td class="align-middle">
                    {{
                      $stock_depot->num
                    }}
                  </td>


                  <td class="align-middle">
                    {{
                      $stock_depot->disponible
                    }}
                  </td>

                  <td class="align-middle">
                    {{
                      $stock_depot->qte_achat
                    }}
                  </td>
                  <td class="align-middle">
                    {{
                      $stock_depot->qte_vente
                    }}
                  </td>
                  <td class="align-middle">
                    {{
                      $stock_depot->qte_achatRes
                    }}
                  </td>
                  <td class="align-middle">
                    {{
                      $stock_depot->qte_venteRes
                    }}
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
                    <button type="button" class="btn btn-dark waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#display{{ $suivi->id }}">
                      <span class="mdi mdi-eye-outline align-middle"></span>
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