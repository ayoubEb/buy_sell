@extends('layouts.master')
@section('title')
  depot : nouveau
@endsection
@section('content')

<h4 class="title-header">
  <a href="{{ route('depot.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  nouveau depôt
</h4>

<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <form action="{{ route('depot.store') }}" method="post">
          @csrf
          <div class="form-group mb-3">
            <label for="" class="form-label">numéro ou nom dépot</label>
            <input type="text" name="num_depot" id="" class="form-control @error('num_depot') is-invalid @enderror" value="{{ old('num_depot') }}">
            @error('num_depot')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
              <div class="form-group mb-3">
                <label for="" class="form-label">
                  adresse
                </label>
                <input type="text" name="adresse" id="" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}">
                @error('adresse')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                @enderror
            </div>
            <div class="row justify-content-center">
              <div class="col-lg-3 col-md-4">
                <button type="submit" class="btn btn-vert waves-effect waves-light w-100">
                  enregistrer
                </button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection