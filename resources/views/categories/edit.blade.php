
@extends('layouts.master')
@section('title')
    Modification catégorie
@endsection
@section('content')
  <div class="d-md-flex justify-content-between align-items-center">
    <h6 class="title-header">
      <a href="{{ route('categorie.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
        <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
      </a>
      catégorie : {{ $categorie->nom }}
    </h6>
  </div>

  <div class="card">
    <div class="card-body p-2">
      <div class="row justify-content-center">
        <div class="col">
          @if (isset($categorie->image))
            <img src="{{ asset('storage/images/category/'.$categorie->image) }}" alt="" class="img-fluid">
            @else
            <img src="{{ asset('images/default.webp') }}" alt="" class="img-fluid">
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

            <div class="row justify-content-center">


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
