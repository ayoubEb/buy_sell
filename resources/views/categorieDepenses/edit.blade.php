@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">modifier de catégorie dépense :  {{ $categorieDepense->nom }} </h4>
    </div>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('categorieDepense.update',$categorieDepense) }}" method="post">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
            <label for="" class="form-label">nom</label>
            <input type="text" name="nom" id="" class="form-control @error('nom') is-invalid @enderror" value="{{ $categorieDepense->nom }}">
            @error('nom')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">statut</label>
            <select name="statut" id="" class="form-select @error('statut') is-invalid @enderror">
              <option value="">-- choisir le statut --</option>
              <option value="1" {{ $categorieDepense->statut == 1 ? "selected" : '' }} >Activé</option>
              <option value="0" {{ $categorieDepense->statut == 0 ? "selected" : '' }} >Desactivé</option>
            </select>
            @error('statut')
            <strong class="invalid-feedback">
              {{ $message }}
            </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">description</label>
            <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $categorieDepense->description }}</textarea>
          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ route('categorieDepense.index') }}" class="btn btn-orange waves-effect waves-light">
              retour
            </a>
            <button type="submit" class="btn btn-vert waves-effect waves-light">
              mettre à jour
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection