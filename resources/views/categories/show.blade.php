@extends('layouts.master')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h6 class="title-header m-0">
    <a href="{{ route('categorie.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    catégorie : {{ $categorie->nom }}
  </h6>
  <div class="">
      @can("categorie-modification")
        <a href="{{ route('categorie.edit',$categorie) }}" class="btn btn-brown waves-effect waves-light px-3">
          <span class="mdi mdi-pencil-outline align-middle"></span>
          <span>modification</span>
        </a>
      @endcan
      @can("categorie-suppression")
      <button type="button" class="btn btn-brown px-3 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{ $categorie->id }}">
        <span class="mdi mdi-trash-can-outline align-middle"></span>
        <span>suppression</span>
      </button>
      <div class="modal fade" id="delete{{ $categorie->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
              <div class="d-flex justify-content-center">
                <span class="mdi mdi-trash-can-outline mdi-48px text-danger"></span>
              </div>
              <form action="{{ route('categorie.destroy',$categorie) }}" method="POST">
                @csrf
                @method("DELETE")
                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                <h6 class="fw-bolder text-center text-muted">
                  Voulez-vous vraiment la suppression du categorie
                </h6>
                <h6 class="text-danger my-3 text-center">{{ $categorie->designation }}</h6>
                <div class="row justify-content-center">
                  <div class="col-6">
                    <button type="submit" class="btn btn-vert waves-effect waves-light me-2 py-2 w-100">
                      Je confirme
                    </button>
                  </div>
                  <div class="col-6">
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
<div class="card">
  <div class="card-body p-2">

    <div class="row">
      <div class="col-lg-3">
        @if($categorie->image != null)
        <img src="{{ asset('storage/images/categories/'.$categorie->image ?? '') }}" alt="" class="img-fluid mb-2">
        @else
          <img src="{{ asset('images/default.webp') }}" alt="" class="w-100 mb-2">
        @endif
      </div>
      <div class="col">
        <div class="table-responsive">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">nom</td>
                <td class="align-middle"> {{ $categorie->nom }} </td>
              </tr>
              <tr>
                <td class="align-middle">description</td>
                <td class="align-middle"> {{ $categorie->description ?? "N / A"}} </td>
              </tr>
              <tr>
                <td class="align-middle">date création</td>
                <td class="align-middle"> {{ date("d/m/Y",strtotime($categorie->created_at)) }} </td>
              </tr>
            </tbody>
            @if ($categorie->description != '')
              <tfoot>
                <tr>
                  <td class="align-middle" colspan="2">
                    {{ $categorie->description ?? ''}}
                  </td>
                </tr>
              </tfoot>
            @endif
          </table>
        </div>
      </div>
    </div>
    @if (count($suivi_actions) > 0)
      <h5 class="title text-center mt-3">
        historiques
      </h5>

      <div class="table-repsonsive">
        <table class="table table-customize m-0">
          <thead>
            <tr>
              <th>opération</th>
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
                  <div class="modal fade modal-lg" tabindex="-1" id="display{{ $suivi->id }}" aria-labelledby="mySmallModalLabel" style="display: none;" aria-hidden="true">
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
                            $properties = json_decode($suivi->properties, true);
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
    @endif

  </div>
</div>
@endsection