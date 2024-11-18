
@extends('layouts.master')
@section('title')
    Modification catégorie
@endsection
@section('content')
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="page-title mb-0 font-size-18">Dashboard</h4>

          <div class="page-title-right">
              <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">Welcome to Qovex Dashboard</li>
              </ol>
          </div>

      </div>
  </div>
</div>
  <div class="card">
    <div class="card-body p-2">
      <div class="row justify-content-center">
        <div class="col">
          @if (isset($categorie->image))
            <img src="{{ asset('storage/images/category/'.$categorie->image) }}" alt="" class="img-fluid">
            @else
            <img src="{{ asset('images/default.jpg') }}" alt="" class="img-fluid">
          @endif
        </div>
        <div class="col-lg-8">
          <form action="{{ route('categorie.update',$categorie) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row row-cols-2">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Nom</label>
                  <input type="text" name="nom" id="" class="form-control @error('nom') is-invalid @enderror" value="{{ $categorie->nom }}">
                  @error('nom')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">image</label>
                  <input type="file" name="img" id="" class="form-control">
                </div>
              </div>
            </div>
            <div class="form-group mb-2">
              <label for="" class="form-label">Description</label>
              <textarea name="description" rows="10" class="form-control">{{ $categorie->description }}</textarea>
            </div>

            <div class="row justify-content-between">
              <div class="col-lg-2">
                <a href="{{ route('categorie.index') }}" class="btn btn-retour waves-effect waves-light w-100">
                  <span>
                      retour
                  </span>
                </a>

              </div>

              <div class="col-lg-2">
                  <button type="submit" class="btn btn-vert waves-effect waves-light w-100">
                      <span>mettre à jour</span>
                  </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
