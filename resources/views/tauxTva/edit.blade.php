@extends('layouts.master')
@section('content')
<div class="d-md-flex justify-content-between align-items-center">
  <h4 class="title-header">
    <a href="{{ route('tauxTva.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    tva : {{ $tauxTva->nom }}
  </h4>
  @can('tauxTva-display')
    <a href="{{ route('tauxTva.show',$tauxTva) }}" class="btn btn-darkLight waves-effect waves-light">
      <span class="mdi mdi-eye-outline align-middle"></span>
      voir
    </a>
  @endcan
</div>

<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action="{{ route('tauxTva.update',$tauxTva) }}" method="post">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
            <label for="">nom</label>
            <input type="text" name="nom" class="form-control fc-p @error('nom') is-invalid @enderror" value="{{ $tauxTva->nom ?? null }}">
            @error('nom')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="">Valeur</label>
            <input type="text" name="valeur" id="" class="form-control fc-p @error('valeur') is-invalid @enderror" value="{{ $tauxTva->valeur ?? 0 }}">
            @error('valeur')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">statut</label>
            <select name="statut" id="" class="form-select fc-p">
              <option value="">-- choisir le statut --</option>
              <option value="1" {{ $tauxTva->statut == 1 ? 'selected' : '' }}>Activé</option>
              <option value="0" {{ $tauxTva->statut == 0 ? 'selected' : '' }}>Désactivé</option>
            </select>
          </div>
          <div class="form-group mb-2">
            <label for="">description</label>
            <textarea name="description" id="" rows="10" class="form-control">{{$tauxTva->description ?? 'null'}}</textarea>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-vert waves-effect waves-light">
              <span>mettre à jour</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

