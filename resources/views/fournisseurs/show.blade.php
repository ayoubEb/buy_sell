@extends('layouts.master')
@section('title')
  Liste des fournisseurs
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">fournisseur : {{ $fournisseur->name }}</h4>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
      <!-- Nav tabs -->
      <ul class="nav nav-tabs mt-4" role="tablist">
        <li class="nav-item">
          <a class="nav-link text-uppercase fw-bold  @if(!Session::has('valider')) active @endif" data-bs-toggle="tab" href="#infoFacture" role="tab">Information</a>
        </li>
        @can('ligneAchat-list')
          <li class="nav-item">
            <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#achats" role="tab">les achats</a>
          </li>
        @endcan
      </ul>
      <div class="tab-content">
        <div class="tab-pane p-0 pt-3 @if(!Session::has('valider')) active @endif" id="infoFacture" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered m-0 info">
              <tbody>
                <tr>
                  <td class="align-middle">
                    identifiant
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->identifiant != '' ?
                      $fournisseur->identifiant : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    raison sociale
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->raison_sociale != '' ?
                      $fournisseur->raison_sociale : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    adresse
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->adresse != '' ?
                      $fournisseur->adresse : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    ville
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->ville != '' ?
                      $fournisseur->ville : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    code postal
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->code_postal != '' ?
                      $fournisseur->code_postal : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    rc
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->rc != '' ?
                      $fournisseur->rc : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    ice
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->ice != '' ?
                      $fournisseur->ice : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    téléphone
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->phone != '' ?
                      $fournisseur->phone : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    fix
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->fix != '' ?
                      $fournisseur->fix : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    email
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->email != '' ?
                      $fournisseur->email : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">
                    pays
                  </td>
                  <td class="align-middle">
                    {!!
                      $fournisseur->pays != '' ?
                      $fournisseur->pays : '<i>aucun</i>'
                    !!}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane p-0 pt-3" id="achats" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered m-0 table-customize">
              <thead>
                <tr>
                  <th>référence</th>
                  <th>date</th>
                  <th>montant</th>
                  <th>payer</th>
                  <th>reste</th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($ligneAchats as $ligneAchat)
                  <tr>
                    <td class="align-middle">
                      {{ $ligneAchat->num_achat }}
                    </td>
                    <td class="align-middle">
                      {{ $ligneAchat->date_achat }}
                    </td>
                    <td class="align-middle fw-bolder">
                      {{ number_format($ligneAchat->prix_ttc , 2 , "," ," ") }} dh
                    </td>
                    <td class="align-middle fw-bolder">
                      <span class="text-success">
                        {{ number_format($ligneAchat->payer , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle fw-bolder">
                      <span class="text-danger">
                        {{ number_format($ligneAchat->reste , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle fw-bolder">
                      <a href="{{ route('ligneAchat.show',$ligneAchat) }}" class="btn btn-primary waves-effect waves-light py-1 px-2 rounded-circle" target="_blank">
                        <span class="mdi mdi-eye-outline align-middle"></span>
                      </a>
                      @if ($ligneAchat->status == "validé")

                      <a href="{{ route('ligneAchat.show',$ligneAchat) }}" class="btn btn-dark waves-effect waves-light py-1 px-2 rounded-circle">
                          <span class="mdi mdi-file-outline"></span>
                        </a>
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection