@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">modification de dépense : {{ $depense->dateDepense }} </h4>
    </div>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('depense.update',$depense) }}" method="post">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
            <label for="" class="form-label">catégorie</label>
            <select name="categorie" id="" class="form-select @error('categorie') is-invalid @enderror">
              <option value="">-- choisir le catégorie --</option>
              @foreach ($categorieDepenses as $categorie)
                <option value="{{ $categorie->id }}" {{ $categorie->id == $depense->categorie_depense_id ? "selected" : "" }} > {{ $categorie->nom }} </option>
              @endforeach
            </select>
            @error('categorie')
            <strong class="invalid-feedback">
              {{ $message }}
            </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">montant</label>
            <input type="number" name="montant" id="" min="0" step="any" class="form-control @error('montant') is-invalid @enderror" value="{{ $depense->montant }}">
            @error('montant')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">date</label>
            <input type="date" name="dateDepense" class="form-control @error('dateDepense') is-invalid @enderror" value="{{ old('dateDepense') == null || $depense->dateDense== null ? date('Y-m-d') : old('dateDepense') }}">
            @error('dateDepense')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">statut</label>
            <select name="statut" id="" class="form-select @error('statut') is-invalid @enderror">
              <option value="">-- choisir le statut --</option>
              <option value="en cours" {{ $depense->statut == "en cours" ? "selected" : "" }}>En cours</option>
              <option value="annuler" {{ $depense->statut == "annuler" ? "selected" : "" }}>Annuler</option>
              <option value="faire" {{ $depense->statut == "faire" ? "selected" : "" }}>Faire</option>
            </select>
            @error('statut')
            <strong class="invalid-feedback">
              {{ $message }}
            </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">description</label>
            <textarea name="description" id="" cols="30" rows="10" class="form-control">{{ $depense->description }}</textarea>
          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ route('depense.index') }}" class="btn btn-orange waves-effect waves-light">
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