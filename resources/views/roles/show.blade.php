@extends('layouts.master')
@section('title')
Authorisation : {{ $role->name }}
@endsection
@section('content')
<div class="card">
    <div class="card-body">
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
                    {!! in_array($categorie->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($fournisseur->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($produit->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($ligneAchat->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($user->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($role->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($achatPaiement->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
                  {!! in_array($tauxTva->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
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
              {!! in_array($stockSuivi->id, $rolePermissions) == true ? '<span class="mdi mdi-check-bold text-success"></span>' : '<span class="mdi mdi-close text-danger"></span>' !!}
            </td>
            @endforeach
          </tr>
          {{-- ============ --}}
          {{-- end stockSuivis --}}

        </tbody>
      </table>
    </div>
    <a href="{{ route('role.index') }}" class="btn btn-sm btn-info">Retour</a>
    </div>
</div>



@endsection
