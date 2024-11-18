@extends('layouts.master')
@section('title')
  new stock
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

<div class="row justify-content-center">
  <div class="col-xxl-9">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('stock.store') }}" method="post">
          @csrf
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">référence <span class="text-danger">*</span></label>
                <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" readonly value="{{ $produit->reference }}">
                @error('reference')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Quantite <span class="text-danger">*</span></label>
                <input type="number" name="quantite" id="" class="form-control @error('quantite') is-invalid @enderror" min="1" value="{{ old('quantite') }}">
                @error('quantite')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Initial <span class="text-danger">*</span></label>
                <input type="number" name="initial" id="" class="form-control @error('initial') is-invalid @enderror" min="1" value="{{ old('initial') }}">
                @error('initial')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Min <span class="text-danger">*</span></label>
                <input type="number" name="qte_min" id="" class="form-control @error('qte_min') is-invalid @enderror" min="1" value="{{ old('qte_min') }}">
                @error('qte_min')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>


          </div>
          <div class="d-flex justify-content-between">
            @can('stock-list')
              <a href="{{ route('stock.index') }}" class="btn btn-orange waves-effect waves-light">
                retour
              </a>
            @endcan
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
