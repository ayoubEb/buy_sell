@extends('layouts.master')

@section("content")
<div class="card">
  <div class="card-body p-2">
    <form action="{{ route('entreprise.update',$entreprise) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method("PUT")
      <div class="row row-cols-3">

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">logo</label>
            <input type="file" name="logo" id="" class="form-control">
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Raison Sociale <span class="text-danger"> * </span></label>
            <input type="text" name="raison_sociale" id="" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ $entreprise->raison_sociale }}">
            @error('raison_sociale')
                <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">ICE <span class="text-danger"> * </span></label>
            <input type="text" name="ice" id="" class="form-control @error('ice') is-invalid @enderror" value="{{ $entreprise->ice }}">
            @error('ice')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">RC <span class="text-danger"> * </span></label>
            <input type="text" name="rc" id="" class="form-control @error('rc') is-invalid @enderror" value="{{ $entreprise->rc }}">
            @error('rc')
                <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">IF <span class="text-danger"> * </span></label>
            <input type="text" name="if" id="" class="form-control @error('if') is-invalid @enderror" value="{{ $entreprise->if }}">
            @error('if')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Téléphone <span class="text-danger"> * </span></label>
            <input type="text" name="telephone" id="" class="form-control @error('telephone') is-invalid @enderror" value="{{ $entreprise->telephone }}">
            @error('telephone')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">fix</label>
            <input type="text" name="fix" id="" class="form-control" value="{{ $entreprise->fix }}">
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Patente <span class="text-danger"> * </span></label>
            <input type="text" name="patente" id="" class="form-control @error('patente') is-invalid @enderror" value="{{ $entreprise->patente }}">
            @error('patente')
                <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">E-mail <span class="text-danger"> * </span></label>
            <input type="email" name="email" id="" class="form-control @error('email') is-invalid @enderror" value="{{ $entreprise->email }}">
            @error('email')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Site <span class="text-danger"> * </span></label>
            <input type="text" name="site" id="" class="form-control @error('site') is-invalid @enderror" value="{{ $entreprise->site }}">
            @error('site')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">CNSS <span class="text-danger"> * </span></label>
            <input type="text" name="cnss" id="" class="form-control @error('cnss') is-invalid @enderror" value="{{ $entreprise->cnss }}">
            @error('cnss')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Adresse <span class="text-danger"> * </span></label>
            <input type="text" name="adresse" id="" class="form-control @error('adresse') is-invalid @enderror" value="{{ $entreprise->adresse }}">
            @error('adresse')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Ville <span class="text-danger"> * </span></label>
            <input type="text" name="ville" id="" class="form-control @error('ville') is-invalid @enderror" value="{{ $entreprise->ville }}">
            @error('ville')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Code postal <span class="text-danger"> * </span></label>
            <input type="text" name="code_postal" id="" class="form-control @error('code_postal') is-invalid @enderror" value="{{ $entreprise->code_postal }}">
            @error('code_postal')
              <strong class="invalid-feedback">{{ $message }}</strong>
            @enderror
          </div>
        </div>

        <div class="col-8">
          <div class="form-group">
            <label for="" class="form-label">description</label>
          <textarea name="description" id="" rows="1" class="form-control">{{ $entreprise->description }}</textarea>
          </div>
        </div>

      </div>

      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-vert waves-effect waves-light">
          <span>mettre à jour</span>
        </button>
      </div>

    </form>
  </div>
</div>
@endsection
