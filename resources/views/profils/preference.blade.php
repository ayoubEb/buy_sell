@extends('layouts.master')
@section('content')
<div class="card">
    <div class="card-body p-2">
        @if (Session::has('update'))
            <div class="alert alert-fill-primary mb-2" role="alert">
                {{ Session::get('update') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <form action="{{ route('profil.update',$user) }}" method="post">
                    @csrf
                    @method("PUT")
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Name</label>
                        <input type="text" name="name" id="" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ $user->name }}">
                        @error('name')
                            <strong class="invalid-feedback">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Email</label>
                        <input type="email" name="email" id="" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ $user->email }}">
                        @error('email')
                            <strong class="invalid-feedback">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="" class="form-control form-control-sm @error('password') is-invalid @enderror">
                        @error('password')
                            <strong class="invalid-feedback">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label for="" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" id="" class="form-control form-control-sm">
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-success px-3 py-1">
                            <span class="mdi mdi-checkbox-marked-circle-outline align-middle" style="font-size: 0.90rem;"></span>
                            <span>Modifier</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
