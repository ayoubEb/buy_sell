@extends('layouts.master')
@section('title')
  new stock
@endsection
@section('content')

<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="page-title mb-0 font-size-18">modifier le stock : {{ $stock->num }} </h4>

          <div class="page-title-right">
              <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">modifier le stock : {{ $stock->num }} </li>
              </ol>
          </div>

      </div>
  </div>
</div>
<div class="row justify-content-center">
  <div class="col-xxl-9">
    <div class="d-flex justify-content-between mb-2">
      <a href="{{ route('stock.index') }}" class="btn btn-orange waves-effect waves-light">
        retour
      </a>
      @can('stock-display')
        <a href="{{ route('stock.show',$stock) }}" class="btn btn-brown waves-effect waves-light">
          <span class="mdi mdi-eye-outline align-middle align-middle"></span>
          détails
        </a>
      @endcan

    </div>
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('stock.update',$stock) }}" method="post">
          @csrf
          @method("PUT")
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">référence</label>
                <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" readonly value="{{ $stock->num }}">
                @error('reference')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>


            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Initial</label>
                <input type="number" name="initial" id="" class="form-control @error('initial') is-invalid @enderror" min="1" value="{{ $stock->initial }}">
                @error('initial')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Min</label>
                <input type="number" name="qte_min" id="" class="form-control @error('qte_min') is-invalid @enderror" min="1" value="{{ $stock->min }}">
                @error('qte_min')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Max</label>
                <input type="number" name="qte_max" id="" class="form-control @error('qte_max') is-invalid @enderror" min="1" value="{{ $stock->max }}">
                @error('qte_max')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

          </div>
          <div class="d-flex justify-content-center">

            <button type="submit" class="btn btn-vert waves-effect waves-light">
              mettre à jour
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
