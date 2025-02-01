@extends('layouts.master')
@section('content')
<h6 class="title-header m-0">
  liste des documents
</h6>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-customize table-doc">
        <thead>
          <tr>
            <th>liste</th>
            <th>opération</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="align-middle">
              <span>
                catégories
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('categorie.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                produits
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('produit.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                stock
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('stock.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                stock depôts
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('stockDepot.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                tva
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('tauxTva.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                depôts
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('depot.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                fournisseurs
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('fournisseur.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                clients
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('client.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                ligne d'achats
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('ligneAchat.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                achat paiements
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('achatPaiement.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                ligne des ventes
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('ligneVente.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                vente paiements
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('ventePaiement.document') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-outline align-middle"></span>
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
    {{-- .row.row-cols- --}}
@endsection