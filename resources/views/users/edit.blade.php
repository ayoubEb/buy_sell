@extends('layouts.master')
@section('title')
    Liste des utilisateurs
@endsection
@section('content')
@include('layouts.session')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">modifier utilisateur : {{ $user->name }} </h4>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body">
    <form action="{{ route("user.update",$user) }}" method="POST" >
      @csrf
      @method("PUT")

      <div class="row row-cols-lg-2 row-cols-1">
          <div class="col mb-2">
              <div class="form-group">
                  <label for="" class="form-label">Name</label>
                  <input type="text" name="name" id="" class="form-control @error("name") is-invalid @enderror" value="{{ $user->name ?? "" }}">
                  @error("name")
                      <strong class="invalid-feedback">{{ $message }}</strong>
                  @enderror
              </div>
          </div>
          <div class="col mb-2">
              <div class="form-group">
                  <label for="" class="form-label">Email</label>
                  <input type="email" name="email" id="" class="form-control form-control-sm @error("email") is-invalid @enderror" value="{{ $user->email ?? "" }}">
                  @error("email")
                      <strong class="invalid-feedback">{{ $message }}</strong>
                  @enderror
              </div>
          </div>

          <div class="col mb-2">
              <div class="form-group">
                  <label for="" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                  <div class="input-group">
                      <span class="input-group-text">
                          <i class="toggle-password mdi mdi-eye-off-outline"></i>
                      </span>
                      <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">
                  </div>

                  @error("password")
                      <strong class="invalid-feedback">{{ $message }}</strong>
                  @enderror
              </div>
          </div>
          <div class="col mb-2">
              <div class="form-group">
                  <label for="" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                  <div class="input-group">
                      <span class="input-group-text" id="basic-addon1">
                          <i class="toggle-password mdi mdi-eye-off-outline"></i>
                      </span>
                      <input type="password" name="password_confirmation" class="form-control">
                  </div>
              </div>
          </div>
      </div>

      <div class="form-group">
          <label for="" class="form-label d-block">Roles <span class="text-danger">*</span></label>
          {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple')) !!}
      </div>



      <div class="d-flex justify-content-between">
        @can('user-modification')
          <a href="{{ route('user.index') }}" class="btn btn-brown waves-effect waves-light">
            liste
          </a>

        @endcan
          <button type="submit" class="btn btn-vert px-2 p-0 waves-effect waves-light">
              <span>Modifier</span>
          </button>
      </div>

    </form>
  </div>
</div>
@endsection
