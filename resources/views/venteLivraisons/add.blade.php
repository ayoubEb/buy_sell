@extends('layouts.master')
@section('title')
    livraison de facture : {{ $facture->num ?? '' }}
@endsection
@section('content')
  {{-- @include('ligneFactures.minInfo',[ "id"=>$facture->id ]) --}}
  <h6 class="title mb-1">
    <span>livraison</span>
  </h6>
  <div class="card">
    <div class="card-body p-2">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <form action="{{ route('factureLivraison.store') }}" method="post">
            @csrf
            <input type="hidden" name="facture_id" value="{{ $facture->id }}">
            <div class="row row-cols-2">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">villes </label>
                  <select name="livraison_id" id="liv" class="form-select @error('livraison_id') is-invalid @enderror">
                    <option value="">Choisir le ville</option>
                    @foreach ($livraisons as $livraison)
                      <option value="{{ $livraison->id }}" {{ old("livraison_id") == $livraison->id ? "selected":"" }}>{{ $livraison->ville }}</option>
                    @endforeach
                  </select>
                  @error('livraison_id')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">prix</label>
                  <input type="number" name="price" min="0" step="any" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
                  @error('price')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">date</label>
                  <input type="date" name="date_livraison" id="" class="form-control @error('date_livraison') is-invalid @enderror" value="{{ old('date_livraison') == null ? date('Y-m-d') : old('date_livraison') }}">
                  @error('date_livraison')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">status </label>
                  <select name="statut" id="" class="form-select @error('statut') is-invalid @enderror">
                    <option value="">Choisir le statut</option>
                    <option value="livré" {{ old("statut") == "livré" ? "selected" : "" }}>livré</option>
                    <option value="en cours" {{ old("statut") == "en cours" ? "selected" : "" }}>en cours</option>
                  </select>
                  @error('statut')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
            </div>
            <div class="form-group mb-2">
              <label for="" class="form-label">adresse</label>
              <input type="text" name="adresse" id="" class="form-control @error('adresse') is-invalid @enderror" value="{{ old('adresse') }}">
              @error('adresse')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
            <div class="d-flex justify-content-between">
              <a href="{{ route('facture.index') }}" class="btn btn-retour waves-effect waves-light px-5">
                retour
              </a>
              <button type="submit" class="btn btn-action waves-effect waves-light px-5">
                enregistrer
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @endsection

@section('script')
<script>
  $(document).ready(function () {
    $(document).on("change","#liv",function(){
      let id = $(this).val();
      let out = "";
            $.ajax({
                type:"GET",
                url:"{{ route('livraisonPrice') }}",
                data:{"id":id},
                success:function(data){
                  $("#price").val(data)


                }
            })
    })
  });
</script>
@endsection