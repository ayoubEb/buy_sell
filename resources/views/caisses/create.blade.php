@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">nouveau dépense</h4>
    </div>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-lg-7">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('caisse.store') }}" method="post">
          @csrf
          <div class="form-group mb-2">
            <label for="" class="form-label">catégorie</label>
            <select name="categorie" id="" class="form-select @error('categorie') is-invalid @enderror">
              <option value="">-- choisir le catégorie --</option>
              @foreach ($categorieCaisses as $categorie)
                <option value="{{ $categorie->id }}" {{ $categorie->id == old("categorie") ? "selected" : "" }} > {{ $categorie->nom }} </option>
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
            <input type="number" name="montant" id="" min="0" step="any" class="form-control @error('montant') is-invalid @enderror" value="{{ old('montant') }}">
            @error('montant')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">date</label>
            <input type="date" name="dateCaisse" class="form-control @error('dateCaisse') is-invalid @enderror" value="{{ old('dateCaisse') == null ? date('Y-m-d') : old('dateCaisse') }}">
            @error('dateCaisse')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">statut</label>
            <select name="statut" id="" class="form-select @error('statut') is-invalid @enderror">
              <option value=""> -- choisir le statut -- </option>
              <option value="en cours" {{ old("statut") == "en cours" ? "selected" : "" }}>En cours</option>
              <option value="annuler" {{ old("statut") == "annuler" ? "selected" : "" }}>Annuler</option>
              <option value="faire" {{ old("statut") == "faire" ? "selected" : "" }}>Faire</option>
            </select>
            @error('statut')
            <strong class="invalid-feedback">
              {{ $message }}
            </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">opération</label>
            <select name="operation" id="" class="form-select @error('operation') is-invalid @enderror">
              <option value="">-- choisir le operation --</option>
              <option value="Révenu" {{ old("operation") == "Révenu" ? "selected" : "" }}>Révenu</option>
              <option value="dépense" {{ old("operation") == "dépense" ? "selected" : "" }}>dépense</option>
            </select>
            @error('operation')
            <strong class="invalid-feedback">
              {{ $message }}
            </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">observation</label>
            <textarea name="observation" id="" cols="30" rows="10" class="form-control">{{ old('observation') }}</textarea>
          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ route('caisse.index') }}" class="btn btn-orange waves-effect waves-light">
              retour
            </a>
            <button type="submit" class="btn btn-vert waves-effect waves-light">
              enregistrer
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection