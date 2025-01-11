@extends('layouts.master')
@section('content')
  <div class="d-flex d-md-flex align-items-center justify-content-between">
    <h6 class="title-header m-0">
      <a href="{{ route('stockDepot.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
        <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
      </a>
      modification de stock
    </h6>
    <a href="{{ route('stockDepot.show',$stockDepot) }}" class="btn btn-brown waves-effect waves-light">
      <span class="mdi mdi-eye-outline align-middle"></span>
      <span>voir</span>
    </a>
  </div>

  <div class="card">
    <div class="card-body p-2">
      <form action="{{ route('stockDepot.update',$stockDepot) }}" method="post">
        @csrf
        @method("PUT")
        <div class="form-group">
          <label for="" class="form-label">Default</label>
          <select name="check_default" class="form-select">
            <option value="">-- Séléctionner --</option>
            <option value="1" {{ $stockDepot->check_default == 1 ? 'selected' : '' }}> Active </option>
            <option value="0" {{ $stockDepot->check_default == 0 ? 'selected' : '' }}> Inactive </option>
          </select>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-3">
            <button type="submit" class="btn btn-vert waves-effect waves-light">
              mettre à jour
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection