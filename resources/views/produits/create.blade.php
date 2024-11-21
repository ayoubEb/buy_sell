@extends('layouts.master')
@section('title')
    Ajouter une produit
@endsection
@section('content')
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="page-title mb-0 font-size-18">nouveau produit</h4>
      </div>
  </div>
</div>
    <form action="{{ route('produit.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="card">
        <div class="card-body p-2">
          <div class="row justify-content-center">
            <div class="col-xxl-8 col-xl-10">
              <div class="form-group mb-2">
                <label for="" class="form-label">Designation du produit <span class="text-danger"> * </span></label>
                <input type="text" name="designation" id="" class="form-control @error('designation') is-invalid @enderror" value="{{old('designation')}}">
                @error('designation')
                  <strong class="invalid-feedback">
                      {{ $message }}
                  </strong>
                @enderror
              </div>
              <div class="row row-cols-md-2 row-cols-1">

                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Référence <span class="text-danger"> * </span></label>
                    <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference') }}">
                    @error("reference")
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                  </div>
                </div>
                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Prix d'achat <span class="text-danger"> * </span></label>
                    <input type="number" name="prix_achat" id="" class="form-control  @error('prix_achat') is-invalid @enderror" min="0" step="any" value="{{ old('prix_achat') }}">
                    @error('prix_achat')
                      <strong class="invalid-feedback">
                        {{ $message }} ex : 0/0.00
                      </strong>
                    @enderror
                  </div>
                </div>
                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Prix Revient <span class="text-danger"> * </span></label>
                    <input type="number" name="prix_revient" id="" class="form-control  @error('prix_revient') is-invalid @enderror" min="0" step="any" value="{{ old('prix_revient') }}">
                    @error('prix_revient')
                      <strong class="invalid-feedback">
                        {{ $message }} ex : 0/0.00
                      </strong>
                    @enderror
                  </div>
                </div>

                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">Catégorie</label>
                    <select name="categorie" id="" class="form-select @error('categorie') is-invalid @enderror">
                      <option value="">Choisir la catégorie</option>
                      @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ old('categorie') == $categorie->id ? "selected": "" }}>{{ $categorie->nom ?? '' }} </option>
                      @endforeach
                    </select>
                    @error('categorie')
                      <strong class="invalid-feedback"> {{ $message }} </strong>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="form-group mb-2">
                  <label for="" class="form-label">Description</label>
                  <textarea name="description" id=""  rows="5" class="form-control">{{ old('description') }}</textarea>
                  @error('description')
                    <span class="invalid-feedback">{{$message}}</span>
                  @enderror
            </div>
            </div>
            <div class="col">
              <div class="form-group mb-2">
                <label for="" class="form-label">statut</label>
                <select name="statut" id="" class="form-select">
                  <option value="">-- choisir le statut--</option>
                  <option value="1">Activé</option>
                  <option value="0">Desactuvé</option>
                </select>
              </div>
              <div class="form-group mb-2">
                <label for="" class="form-label">Image</label>
                <input type="file" name="img" id="fileImg" class="form-control mb-2">
              </div>
              <div class="form-group">
                <label for="" class="form-label">voir</label>
                <img id="fileVoir" src="" class="img-fluid d-block" alt="Image de fiche" />
              </div>
            </div>

              <div class="d-flex justify-content-between">
                @can('produit-list')
                  <a href="{{ route('produit.index') }}" class="btn btn-orange waves-effect waves-light">
                    liste
                  </a>

                @endcan
                <button type="submit" class="btn btn-vert waves-effect waves-light">
                  <span>Enregistrer</span>
                </button>
              </div>


          </div>

        </div>


    </div>

  </form>


@endsection

@section('script')
  <script>
    $(document).ready(function () {
      fileImg.onchange = evt => {
        const [file] = fileImg.files
        if (file) {
          fileVoir.src = URL.createObjectURL(file)
        }
      }
    });
  </script>
@endsection

