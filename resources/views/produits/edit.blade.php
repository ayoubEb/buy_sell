@extends('layouts.master')
@section('content')
<h6 class="title-header mb-2">
  <a href="{{ route('produit.index') }}" class="btn btn-brown-outline px-4 py-1">
    <span class="mdi mdi-arrow-left-thick mdi-24px"></span>
  </a>
  modifier le produit : {{ $produit->reference }}
</h6>
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

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">marque</label>
                <select name="marque" id="" class="form-select @error('marque') is-invalid @enderror">
                  <option value="">Choisir la marque</option>
                  @foreach ($marques as $marque)
                    <option value="{{ $marque->id }}" {{ $produit->marque_id == $marque->id ? "selected": "" }}>{{ $marque->nom }} </option>
                  @endforeach
                </select>
                @error('marque')
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
            <img src="{{ asset('images/produit_default.png') }}" alt="" class="w-100 " id="fileVoir">
          @endif
        </div>
      </div>

      <div class="d-flex justify-content-between mt-2">
        @can('produit-list')
          <a href="{{ route('produit.index') }}" class="btn btn-orange waves-effect waves-light">
            retour
          </a>
        @endcan
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

