@extends('layouts.master')
@section('content')
<h6 class="title-header m-0">
  liste des fiches exports
</h6>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered table-customize ">
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
              <a href="{{ route('categorie.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('categorie.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
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
              <a href="{{ route('produit.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('produit.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                stocks
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('stock.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('stock.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
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
              <a href="{{ route('stockDepot.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('stockDepot.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                taux tvas
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('tauxTva.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('tauxTva.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
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
              <a href="{{ route('depot.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('depot.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
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
              <a href="{{ route('fournisseur.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('fournisseur.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
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
              <a href="{{ route('client.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('client.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                ligne achats
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('ligneAchat.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('ligneAchat.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
              </a>
            </td>
          </tr>
          <tr>
            <td class="align-middle">
              <span>
                ligne ventes
              </span>
            </td>
            <td class="align-middle">
              <a href="{{ route('ligneVente.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('ligneVente.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
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
              <a href="{{ route('achatPaiement.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('achatPaiement.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
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
              <a href="{{ route('ventePaiement.xlsx') }}" class="btn btn-dark waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                xlsx
              </a>
              <a href="{{ route('ventePaiement.csv') }}" class="btn btn-primary waves-effect waves-light p-icon">
                <span class="mdi mdi-file-excel-outline align-middle"></span>
                csv
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