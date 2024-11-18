@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                  <div class="row row-cols-6">
                      <div class="col">
                          <a href="{{ route('categorie.index') }}" class="w-100 btn btn-primary">
                              catégories
                          </a>
                          <a href="{{ route('produit.index') }}" class="w-100 btn btn-primary">
                              produits
                          </a>
                          <a href="{{ route('fournisseur.index') }}" class="w-100 btn btn-primary">
                              fournisseurs
                          </a>
                          <a href="{{ route('entreprise.index') }}" class="w-100 btn btn-primary">
                              entreprises
                          </a>
                      </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
