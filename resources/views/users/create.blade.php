@extends('layouts.master')
@section('title')
    Liste des utilisateurs
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">nouveau utilisateur</h4>
    </div>
  </div>
</div>

  <div class="card">
    <div class="Card-body p-2">
      <form action="{{ route('user.store') }}" method="POST">
        @csrf
        <div class="row row-cols-lg-2 row-cols-1">
            <div class="col mb-2">
                <div class="form-group">
                    <label for="" class="form-label">Name <span class="text-danger">*</span> </label>
                    <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                    @error("name")
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="col mb-2">
                <div class="form-group">
                    <label for="" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="" class="form-control @error("email") is-invalid @enderror" value="{{ old('email') }}" >
                    @error("email")
                        <strong class="invalid-feedback">{{ $message }}</strong>
                    @enderror
                </div>
            </div>
            <div class="col mb-2">
                <div class="form-group">
                    <label for="" class="form-label">Mot de passe <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="toggle-password mdi mdi-eye-off-outline"></i>
                        </span>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}">

                        @error("password")
                            <strong class="invalid-feedback">{{ $message }}</strong>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col mb-2">
                <div class="form-group">
                    <label for="" class="form-label">Confirmer le mot de passe <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon2">
                            <i class="toggle-password mdi mdi-eye-off-outline"></i>
                        </span>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="" class="form-label d-block">Roles <span class="text-danger">*</span></label>
            {!! Form::select('roles[]', $roles,[], array('class' => 'form-select','multiple')) !!}
        </div>
        <div class="form-group d-flex justify-content-center">
            <button type="submit" class="btn btn-success py-1 px-3">
                <i class="mdi mdi-checkbox-marked-circle-outline align-middle"></i>
                <span>Enregistrer</span>
            </button>
        </div>
    </form>
    </div>
  </div>
@endsection

@section('script')
    <script>
        $(".toggle-password").click(function() {
    $(this).toggleClass("mdi mdi-eye-outline align-middle mdi mdi-eye-off-outline");
    input = $(this).parent().parent().find("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
    });
    </script>
@endsection
