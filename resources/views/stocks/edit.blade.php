@extends('layouts.master')
@section('title')
  new stock
@endsection
@section('content')
<div class="d-md-flex justify-content-between align-items-center mb-2">
  <h4 class="title-header">
    <a href="{{ route('stock.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    modifier le stock : {{ $stock->num }}
  </h4>

  <a href="{{ route('stock.show',$stock) }}" class="btn btn-brown waves-effect waves-light">
    <span class="mdi mdi-eye-outline align-middle"></span>
    détails
  </a>
</div>

<div class="row justify-content-center">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('stock.update',$stock) }}" method="post">
          @csrf
          @method("PUT")
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">référence</label>
                <input type="text" name="reference" id="" class="form-control @error('reference') is-invalid @enderror" value="{{ $stock->num }}">
                @error('reference')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>


            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">alert</label>
                <input type="number" name="qte_alert" id="" class="form-control @error('qte_alert') is-invalid @enderror" min="1" value="{{ $stock->qte_alert }}">
                @error('qte_alert')
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
                <input type="number" name="qte_max" id="" class="form-control @error('qte_max') is-invalid @enderror" min="0" value="{{ $stock->max }}">
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
