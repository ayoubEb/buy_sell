@extends('layouts.master')
@section('content')
@if (count($depots) > 0)
  <form action="{{ route('stockDepot.store') }}" method="post">
    @csrf
    <input type="hidden" name="stock_id" value="{{ $stock->id }}">
    <h6 class="title">
      nouveau depôt
    </h6>
    <div class="card">
      <div class="card-body p-2">
        <div class="row justify-content-center">
          <div class="col-lg-9">
            <div class="row row-cols-2">
              <div class="col">
                <div class="form-group">
                  <label for="" class="form-label">depôt</label>
                  <select name="depot" id="" class="form-select">
                    <option value="">-- Séléctionner --</option>
                    @foreach ($depots as $depot)
                      <option value="{{ $depot->id }}" {{ $depot->id == old('depot') }} > {{ $depot->num_depot }} </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col">
                <div class="form-group">
                  <label for="" class="form-label">quantite</label>
                  <input type="number" name="quantite" min="0" id="" class="form-control" value="{{ old('qte') }}">
                </div>
              </div>

              {{-- <div class="col">
                <div class="form-group">
                  <label for="" class="form-label">depot default</label>
                  <select name="depot" id="" class="form-select">
                    <option value="">-- Séléctionner --</option>
                    @foreach ($depots as $depot)
                      <option value="{{ $depot->id }}" {{ $depot->id == old('depot') }} > {{ $depot->num_depot }} </option>
                    @endforeach
                  </select>
                </div>
              </div> --}}
            </div>

            <div class="row justify-content-center mt-2">
              <div class="col-lg-2">
                <button type="submit" class="btn btn-vert waves-effect Waves-light w-100">
                  enregistrer
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
@endif
{{-- @if (count($liste_depots) > 0)
  <div class="row row-cols-2">
    <div class="col">
      <h5 class="title">
        augmentation le depôt
      </h5>
      <div class="card">
        <div class="card-body p-2">
          <form action="" method="post">
            @csrf
            <div class="row row-cols-2">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">depôt</label>
                  <select name="depot_add" id="" class="form-select">
                    <option value="">-- Séléctionner --</option>
                    @foreach ($liste_depots as $lis_dep)
                      <option value="{{ $lis_dep->id }}"> {{ $lis_dep->num_depot }} => {{ $lis_dep->adresse }} </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">quantite</label>
                  <input type="number" name="qte_add" id="" min="1" class="form-control" value="{{ old('qte_add') }}">
                </div>
              </div>
            </div>

            <div class="row justify-content-center">
              <div class="col-lg-1">
                <button type="submit" class="btn btn-action waves-effect waves-light w-100">
                  <span class="mdi mdi-plus-thick"></span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col">
      <h5 class="title">
        démissioner le depôt
      </h5>
      <div class="card">
        <div class="card-body p-2">
          <form action="" method="post">
            @csrf
            <div class="row row-cols-2">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">depôt</label>
                  <select name="depot_dem" id="" class="form-select">
                    <option value="">-- Séléctionner --</option>
                    @foreach ($liste_depots as $lis_dep)
                      <option value="{{ $lis_dep->id }}"> {{ $lis_dep->num_depot }} => {{ $lis_dep->adresse }} </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">quantite</label>
                  <input type="number" name="qte_dem" id="" min="1" class="form-control" value="{{ old('qte_dem') }}">
                </div>
              </div>
            </div>

            <div class="row justify-content-center">
              <div class="col-lg-1">
                <button type="submit" class="btn btn-action waves-effect waves-light w-100">
                  <span class="mdi mdi-minus-thick"></span>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif --}}

<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-customize">
        <thead>
          <tr>
            <th>depot</th>
            <th>adresse</th>
            <th>quantite</th>
            <th>disponible</th>
            <th>entré</th>
            <th>sortie</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($liste_depots as $dep)
            <tr>
              <td class="align-middle">
                {{ $dep->num_depot }}
              </td>
              <td class="align-middle">
                {{ $dep->adresse }}
              </td>
              <td class="align-middle">
                {{
                  $dep->pivot &&
                  $dep->pivot->quantite != '' ?
                  $dep->pivot->quantite : ''
                }}
              </td>
              <td class="align-middle">
                {{
                  $dep->pivot &&
                  $dep->pivot->disponible != '' ?
                  $dep->pivot->disponible : ''
                }}
              </td>
              <td class="align-middle">
                {{
                  $dep->pivot &&
                  $dep->pivot->entre != '' ?
                  $dep->pivot->entre : ''
                }}
              </td>
              <td class="align-middle">
                {{
                  $dep->pivot &&
                  $dep->pivot->sortie != '' ?
                  $dep->pivot->sortie : ''
                }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection