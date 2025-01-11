@extends('layouts.master')
@section('content')
<div class="d-flex d-md-flex align-items-center justify-content-between">
  <h6 class="title-header m-0">
    <a href="{{ route('produit.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    modification de produit : {{ $produit->designation }}
  </h6>
  <a href="{{ route('produit.show',$produit) }}" class="btn btn-brown waves-effect waves-light">
    <span class="mdi mdi-eye-outline align-middle"></span>
    <span>voir</span>
  </a>
</div>
<form action="{{route('produit.update',$produit)}}" method="post" enctype="multipart/form-data">
  @csrf
  @method("PUT")
  <div class="card">
    <div class="card-body p-2">
      <div class="row">
        <div class="col-lg-8">
          <h6 class="title mt-2 mb-3">
            basic information
          </h6>
          <div class="form-group mb-2">
            <label for="" class="form-label">Designation du produit <span class="text-danger"> * </span></label>
            <input type="text" name="designation" id="" class="form-control @error('designation') is-invalid @enderror" value="{{ $produit->designation }}">
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
                <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" value="{{ $produit->reference }}">
                @error("reference")
                    <strong class="invalid-feedback">{{ $message }}</strong>
                @enderror
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Prix d'achat <span class="text-danger"> * </span></label>
                <input type="number" name="prix_achat" id="" class="form-control  @error('prix_achat') is-invalid @enderror" min="0" step="any" value="{{ $produit->prix_achat }}">
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
                <input type="number" name="prix_revient" id="" class="form-control  @error('prix_revient') is-invalid @enderror" min="0" step="any" value="{{ $produit->prix_revient }}">
                @error('prix_revient')
                  <strong class="invalid-feedback">
                    {{ $message }} ex : 0/0.00
                  </strong>
                @enderror
              </div>
            </div>
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Prix Vente <span class="text-danger"> * </span></label>
                <input type="number" name="prix_vente" id="" class="form-control  @error('prix_vente') is-invalid @enderror" min="0" step="any" value="{{ $produit->prix_vente }}">
                @error('prix_vente')
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
                      <option value="{{ $categorie->id }}" {{ $categorie->id == $produit->categorie_id ? "selected" : "" }} >{{ $categorie->nom ?? '' }} </option>
                    @endforeach
                  </select>
                  @error('categorie')
                    <strong class="invalid-feedback"> {{ $message }} </strong>
                  @enderror
              </div>
            </div>

            <div class="col">
              <div class="form-group mb-2">
                <label for="" class="form-label">statut</label>
                <select name="statut" id="" class="form-select">
                  <option value="">-- choisir le statut--</option>
                  <option value="1" {{ $produit->statut == 1 ? "selected" : "" }}>Activé</option>
                  <option value="0" {{ $produit->statut == 0 ? "selected" : "" }}>Desactuvé</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">Description</label>
            <textarea name="description" id="" cols="30" rows="9" class="form-control"> {{ $produit->description }} </textarea>
          </div>

        </div>
        <div class="col">
          <div class="form-group mb-2">
            <label for="" class="form-label">Image</label>
            <input type="file" name="img" id="fileImg" class="form-control mb-2">
          </div>

          @if($produit->image != null)
          <img src="{{ asset('storage/images/produits/'.$produit->image ?? '') }}" alt="" class="img-fluid" id="fileVoir">
          @else
            <img src="{{ asset('images/default.webp') }}" alt="" class="w-100 " id="fileVoir">
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-center mt-2">
        <button type="submit" class="btn btn-vert waves-effect waves-light">
            <span>mettre à jour</span>
        </button>
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

