@extends('layouts.master')
@section('content')
<h6 class="title-header mb-2">
  <a href="{{ route('client.index') }}" class="btn btn-brown-outline px-4 py-1">
    <span class="mdi mdi-arrow-left-thick mdi-18px"></span>
  </a>
  nouveau client
</h6>

<form action="{{ route('client.store') }}" method="post">
  @csrf
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body p-2">
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Raison sociale <span class="text-danger"> * </span></label>
                <input type="text" name="raison_sociale" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ old('raison_sociale') }}">
                @error('raison_sociale')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Responsable <span class="text-danger"> * </span></label>
                <input type="text" name="responsable" class="form-control @error('responsable') is-invalid @enderror" value="{{ old('responsable') }}">
                @error('responsable')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Téléphone  <span class="text-danger"> * </span></label>
                <input type="text" name="telephone" id="" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}">
                @error('telephone')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Activité</label>
                <input type="text" name="activite" id="" class="form-control" value="{{ old('activite') }}">
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">ICE</label>
                <input type="text"  name="ice" class="form-control @error('ice') is-invalid @enderror" min="1" value="{{ old('ice') }}">
                @error('ice')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">IF</label>
                <input type="text" name="if_client" class="form-control @error('if_client') is-invalid @enderror" min="1" value="{{ old('if_client') }}">
                @error('if_client')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">RC</label>
                <input type="text" name="rc" class="form-control @error('rc') is-invalid @enderror" value="{{ old('rc') }}">
                @error('rc')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Adresse <span class="text-danger"> * </span></label>
                <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}">
                @error('adresse')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Ville <span class="text-danger"> * </span></label>
                <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ old('ville') }}">
                @error('ville')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Code postal</label>
                <input type="text" name="code_postal" class="form-control @error('code_postal') is-invalid @enderror" value="{{ old('code_postal') }}">
                @error('text')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">max payé montant</label>
                <input type="number" name="maxMontantPayer" class="form-control @error('maxMontantPayer') is-invalid @enderror" min="0" step="any" value="{{ old('maxMontantPayer') }}">
                @error('maxMontantPayer')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col">
      <h6 class="mb-1 title">
        groupe & type
      </h6>
      <div class="card">
        <div class="card-body p-2">
          <div class="form-group my-2">
            <label for="" class="form-label">Type <span class="text-danger"> * </span></label>
            <select name="type" id="" class="form-control select2" required>
              <option value="">Choisir le type du client</option>
              @foreach ($types as $type)
                <option value="{{ $type }}" {{ $type == old('type') ? 'selected' : '' }}>{{ $type }} </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="" class="form-label">groupe</label>
            <div class="table-responsive">
              <table class="table table-bordered table-sm mb-2">
                <thead>
                  <tr>
                    <th># <span class="text-danger"> * </span></th>
                    <th>nom</th>
                    <th>remise</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($groupes as $group)
                    <tr>
                      <td class="align-middle">
                        <div class="form-check">
                          <label for="{{"a".$group->id}}" class="form-check-label">{{$group->nom}}</label>
                          <input type="radio" name="group_id" id="{{"a".$group->id}}" class="form-check-input" {{ $group->id == old('group_id') ? 'checked':'' }} value="{{$group->id}}">
                        </div>
                      </td>
                      <td class="align-middle"> {{ $group->nom }} </td>
                      <td class="align-middle"> {{ $group->remise }}% </td>
                    </tr>
                  @empty

                  @endforelse
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="d-flex justify-content-between">
    <a href="{{ route('client.index') }}" class="btn btn-retour waves-effect waves-light">Retour</a>
    <button type="submit" class="btn btn-action waves-effect waves-light">
        Enregistrer
    </button>
  </div>



</form>
@endsection