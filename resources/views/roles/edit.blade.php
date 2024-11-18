@extends('layouts.master')
@section('title')
    Modifier l'authorisation : {{ $role->name ?? '' }}
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Acceuil</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">
            <a href="{{ route('role.index') }}">
                Liste des autorisation
            </a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            modifier l'autorisation
        </li>

    </ol>
</nav>
<div class="card">
    <div class="card-body p-2">
        {{-- @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
            </div>
        @endif --}}
        <form action="{{ route('role.update',$role->id) }}" method="post">
          @csrf
          @method("PUT")


          <div class="form-group mb-2">
            <label for="" class="form-label">Nom</label>
            <input type="text" name="name" id="" class="form-control @error('name') is-invalid @enderror" value="{{ $role->name }}">
            @error('name')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>


          <div class="table-responsive">
            <table class="table table-bordered table-sm m-0">
              <thead>
                <tr>
                  <th></th>
                  <th>liste</th>
                  <th>nouveau</th>
                  <th>modification</th>
                  <th>display</th>
                  <th>suppression</th>
                </tr>
              </thead>
              <tbody>
                {{-- ============ --}}
                {{-- start categories --}}
                <tr>
                  <td class="align-middle">
                    catégories
                  </td>
                  @foreach ($categories as $categorie)
                    <td class="align-middle">
                      <div class="form-switch">
                        {{ Form::checkbox('permissions[]', $categorie->name, in_array($categorie->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$categorie->id)) }}
                      </div>
                    </td>
                  @endforeach
                </tr>
                {{-- ============ --}}
                {{-- end categories --}}

                {{-- ============ --}}
                {{-- start fournisseurs --}}
                <tr>
                  <td class="align-middle">
                    fournisseurs
                  </td>
                  @foreach ($fournisseurs as $fournisseur)
                  <td class="align-middle">
                    <div class="form-switch">
                      {{ Form::checkbox('permissions[]', $fournisseur->name, in_array($fournisseur->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$fournisseur->id)) }}
                    </div>
                  </td>
                  @endforeach
                </tr>
                {{-- ============ --}}
                {{-- end fournisseurs --}}


                {{-- ============ --}}
                {{-- start produits --}}
                <tr>
                  <td class="align-middle">
                    produits
                  </td>
                  @foreach ($produits as $produit)
                  <td class="align-middle">
                    <div class="form-switch">
                      {{ Form::checkbox('permissions[]', $produit->name, in_array($produit->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$produit->id)) }}
                    </div>
                  </td>
                  @endforeach
                </tr>
                {{-- ============ --}}
                {{-- end produits --}}


                {{-- ============ --}}
                {{-- start ligne d'achats --}}
                <tr>
                  <td class="align-middle">
                    ligneAchats
                  </td>
                  @foreach ($ligneAchats as $ligneAchat)
                  <td class="align-middle">
                    <div class="form-switch">
                      {{ Form::checkbox('permissions[]', $ligneAchat->name, in_array($ligneAchat->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$ligneAchat->id)) }}
                    </div>
                  </td>
                  @endforeach
                </tr>
                {{-- ============ --}}
                {{-- end ligne d'achats --}}


                {{-- ============ --}}
                {{-- start users --}}
                <tr>
                  <td class="align-middle">
                    utilisateurs
                  </td>
                  @foreach ($users as $user)
                    <td class="align-middle">
                      <div class="form-switch">
                        {{ Form::checkbox('permissions[]', $user->name, in_array($user->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$user->id)) }}
                      </div>
                    </td>
                  @endforeach
                </tr>
                {{-- ============ --}}
                {{-- end users --}}

                {{-- ============ --}}
                {{-- start rôles --}}
                <tr>
                  <td class="align-middle">
                    rôles
                  </td>
                  @foreach ($roles as $role)
                    <td class="align-middle">
                      <div class="form-switch">
                        {{ Form::checkbox('permissions[]', $role->name, in_array($role->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$role->id)) }}
                      </div>
                    </td>
                  @endforeach
                </tr>
                {{-- ============ --}}
                {{-- end rôles --}}

                {{-- ============ --}}
                {{-- start achatPaiements --}}
                <tr>
                  <td class="align-middle">
                    achatPaiements
                  </td>
                  @foreach ($achatPaiements as $achatPaiement)
                    <td class="align-middle">
                      <div class="form-switch">
                        {{ Form::checkbox('permissions[]', $achatPaiement->name, in_array($achatPaiement->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$achatPaiement->id)) }}
                      </div>
                    </td>
                  @endforeach
                </tr>
                {{-- ============ --}}
                {{-- end achatPaiements --}}

              </tbody>
            </table>
          </div>


        <div class="table-responsive">
          <table class="table table-bordered table-sm m-0">
            <thead>
              <tr>
                <th></th>
                <th>liste</th>
                <th>nouveau</th>
                <th>modification</th>
                <th>suppression</th>
              </tr>
            </thead>
            <tbody>

              {{-- ============ --}}
              {{-- start tauxTvas --}}
              <tr>
                <td class="align-middle">
                  taux tvas
                </td>
                @foreach ($tauxTvas as $tauxTva)
                <td class="align-middle">
                  <div class="form-switch">
                    {{ Form::checkbox('permissions[]', $tauxTva->name, in_array($tauxTva->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$tauxTva->id)) }}
                  </div>
                </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end tauxTvas --}}

            </tbody>
          </table>
        </div>


        <div class="table-responsive">
          <table class="table table-bordered table-sm m-0">
            <thead>
              <tr>
                <th></th>
                <th>nouveau</th>
                <th>modification</th>
                <th>suppression</th>
              </tr>
            </thead>
            <tbody>

              {{-- ============ --}}
              {{-- start stockSuivis --}}
              <tr>
                <td class="align-middle">
                  stock historiques
                </td>
                @foreach ($stockSuivis as $stockSuivi)
                  <td class="align-middle">
                    <div class="form-switch">
                      {{ Form::checkbox('permissions[]', $stockSuivi->name, in_array($stockSuivi->id, $rolePermissions) ? true : false, array('class' => 'form-check-input',"style"=>"cursor:pointer",'id'=>'swithe'.$stockSuivi->id)) }}
                    </div>
                  </td>
                @endforeach
              </tr>
              {{-- ============ --}}
              {{-- end stockSuivis --}}

            </tbody>
          </table>
        </div>



        <div class="row row-cols-2">
          <div class="col">
              <a href="{{ route('role.index') }}" class="btn btn-sm btn-info">Retour</a>
          </div>
          <div class="col">
              <button type="submit" class="btn btn-sm btn-primary float-end">Enregistrer</button>
          </div>
      </div>
        </form>
    </div>
</div>


@endsection
