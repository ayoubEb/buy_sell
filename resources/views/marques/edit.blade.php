@extends('layouts.master')
@section('title')
taux tva : {{ $marque->valeur }}
@endsection
@section('content')



<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action="{{ route('marque.update',$marque) }}" method="post">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
            <label for="">nom</label>
            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ $marque->nom }}">
            @error('nom')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>

          <div class="form-group mb-2">
            <label for="" class="form-label">statut</label>
            <select name="statut" id="" class="form-select">
              <option value="">-- choisir le statut --</option>
              <option value="1" {{ $marque->statut == 1 ? 'selected' : '' }}>Activé</option>
              <option value="0" {{ $marque->statut == 0 ? 'selected' : '' }}>Désactivé</option>
            </select>
          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-retour waves-effect waves-light">
              <span>Retour</span>
            </a>
            <button type="submit" class="btn btn-vert waves-effect waves-light">
              <span>Enregistrer</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

