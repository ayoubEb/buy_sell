@extends('layouts.master')
@section('title')
@endsection
@section('content')

<div class="d-flex justify-content-between align-items-center mb-2">
  <h6 class="title-header m-0">
    <a href="{{ route('depot.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    modification de depôt : {{ $depot->num_depot }}
  </h6>
  @can("depot-modification")
    <a href="{{ route('depot.show',$depot) }}" class="btn btn-darkLight waves-effect waves-light px-3">
      <span class="mdi mdi-eye-outline align-middle"></span>
      <span>détails</span>
    </a>
  @endcan
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <form action="{{ route('depot.update',$depot) }}" method="post">
          @csrf
          @method("PUT")
              <div class="form-group mb-3">
                <label for="" class="form-label">
                  nom dépôt
                </label>

                <input type="text" name="num_depot" id="" class="form-control @error('num_depot') is-invalid @enderror" value="{{ $depot->num_depot }}">
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

                <input type="text" name="adresse" id="" class="form-control @error('adresse') is-invalid @enderror" value="{{ $depot->adresse }}">
                @error('adresse')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                @enderror
            </div>
            <div class="row justify-content-center">
              <div class="col-md-3">
                <button type="submit" class="btn btn-vert waves-effect waves-light w-100">
                  mettre à jour
                </button>

              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection