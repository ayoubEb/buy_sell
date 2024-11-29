@extends('layouts.master')
@section('title')
    Modifier le client : {{ $client->raison_sociale ?? '' }}
@endsection
@section('content')


<form action="{{ route('client.update',$client) }}" method="post">
  @csrf
  @method("PUT")
  <div class="card">
    <div class="card-body p-3">
      <div class="row">
        <div class="col-lg-7 col-sm-6">
          <h6 class="text-uppercase mb-3 text-primary">
            <span class="border border-end-0 border-start-0 border-top-0 border-solid border-primary border-2 pb-1">information général</span>
          </h6>
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Raison sociale <span class="text-danger"> * </span></label>
                <input type="text" name="raison_sociale" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ $client->raison_sociale }}">
                @error('raison_sociale')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Responsable <span class="text-danger"> * </span></label>
                <input type="text" name="responsable" class="form-control @error('responsable') is-invalid @enderror" value="{{ $client->responsable }}">
                @error('responsable')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Téléphone  <span class="text-danger"> * </span></label>
                <input type="text" name="telephone" id="" class="form-control @error('telephone') is-invalid @enderror" value="{{ $client->telephone }}">
                @error('telephone')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Activité</label>
                <input type="text" name="activite" id="" class="form-control" value="{{ $client->activite }}">
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">ICE</label>
                <input type="text"  name="ice" class="form-control @error('ice') is-invalid @enderror" value="{{ $client->ice }}">
                @error('ice')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">IF</label>
                <input type="text" name="if_client" class="form-control @error('if_client') is-invalid @enderror"  value="{{ $client->if_client }}">
                @error('if_client')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">RC</label>
                <input type="text" name="rc" class="form-control @error('rc') is-invalid @enderror" value="{{ $client->rc }}">
                @error('rc')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ $client->email }}">
                @error('email')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>


            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Adresse <span class="text-danger"> * </span></label>
                <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror" value="{{ $client->adresse }}">
                @error('adresse')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Ville <span class="text-danger"> * </span></label>
                <input type="text" name="ville" class="form-control @error('ville') is-invalid @enderror" value="{{ $client->ville }}">
                @error('ville')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Code postal</label>
                <input type="text" name="code_postal" class="form-control @error('code_postal') is-invalid @enderror" value="{{ $client->code_postal }}">
                @error('text')
                <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>



            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">max payé montant</label>
                <input type="number" name="maxMontantPayer" class="form-control @error('maxMontantPayer') is-invalid @enderror" min="0" step="any" value="{{ $client->maxMontantPayer }}">
                @error('maxMontantPayer')
                  <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>

          </div>
        </div>
        <div class="col">
          <h6 class="text-uppercase mb-4 text-primary">
              <span class="border border-end-0 border-start-0 border-top-0 border-solid border-primary border-2 pb-1">groupe & type</span>
          </h6>
          <div class="form-group my-2">
            <label for="" class="form-label">Type <span class="text-danger"> * </span></label>
            <select name="type" id="" class="form-select">
              <option value="">Choisir le type du client</option>
              @foreach ($types as $type)
                  <option value="{{ $type }}" {{ $type == $client->type_client ? 'selected':'' }}>{{ $type }} </option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="" class="form-label">group</label>
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
                                  <input type="radio" name="group_id" id="{{"a".$group->id}}" class="form-check-input" {{ $group->id == $client->group_id ? 'checked' :'' }} value="{{$group->id}}">
                              </div>
                          </td>
                          <td class="align-middle"> {{ $group->nom }} </td>
                          <td class="align-middle"> {{ $group->remise }} %</td>
                      </tr>
                    @empty

                    @endforelse
                  </tbody>
                </table>
              </div>


            </div>
          </div>
        </div>

        <div class="d-flex justify-content-between">
          <a href="{{ route('client.index') }}" class="btn btn-retour waves-effect waves-light">
            retour
          </a>
          <a href="{{ route('client.edit',$client) }}" class="btn btn-lien waves-effect waves-light">
            information
          </a>
          <button type="submit" class="btn btn-action waves-effect waves-light">
            Mettre à jour
          </button>
        </div>
      </div>
    </div>
</form>
@endsection