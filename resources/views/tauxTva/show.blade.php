@extends('layouts.master')
@section('content')
<div class="d-md-flex justify-content-between align-items-center mb-3">
  <h4 class="title-header">
    <a href="{{ route('tauxTva.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    tva : {{ $tauxTva->nom }}
  </h4>
  @can('tauxTva-modification')
    <a href="{{ route('tauxTva.edit',$tauxTva) }}" class="btn btn-darkLight waves-effect waves-light">
      <span class="mdi mdi-pencil-outline align-middle"></span>
      modification
    </a>
  @endcan
</div>
  <div class="card">
    <div class="card-body p-2">
      <h5 class="title">
        basic information
      </h5>
      <div class="table-responsive">
        <table class="table table-bordered info">
          <tbody>
            <tr>
              <td class="align-middle">
                nom
              </td>
              <td class="align-middle">
                {!! $tauxTva->nom != '' ? $tauxTva->nom : '<i class="text-muted">N / A</i>' !!}
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                valeur
              </td>
              <td class="align-middle">
                {{ $tauxTva->valeur }} %
              </td>
            </tr>
            <tr>
              <td class="align-middle">
                description
              </td>
              <td class="align-middle">
                {!! $tauxTva->description != '' ? $tauxTva->description : '<i class="text-muted">N / A</i>' !!}
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <h5 class="title">
        historiques
      </h5>
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
@endsection