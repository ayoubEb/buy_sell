@extends('layouts.master')
@section('title')
taux tva : {{ $tauxTva->valeur }}
@endsection
@section('content')



<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action="{{ route('tauxTva.update',$tauxTva) }}" method="post">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
            <label for="">nom</label>
            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ $tauxTva->nom }}">
            @error('nom')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="">Valeur</label>
            <input type="text" name="valeur" id="" class="form-control @error('valeur') is-invalid @enderror" value="{{ $tauxTva->valeur }}">
            @error('valeur')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="">description</label>
            <textarea name="description" id="" rows="10" class="form-control"> {{$tauxTva->description}}</textarea>
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

