@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">s</h4>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    <div class="table-responsive">
      <table class="table table-bordered m-0 table-customize">
        <thead>
          <tr>
            <th>référence</th>
            <th>fournisseur</th>
            <th>date</th>
            <th>status</th>
            <th>montant ht</th>
            <th>montant ttc</th>
            <th>payer</th>
            <th>reste</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($achats as $achat)
            <tr>
              <td class="align-middle">
                {{ $achat->num_achat }}
              </td>
              <td class="align-middle">
                {{ $achat->fournisseur->raison_sociale   }}
              </td>
              <td class="align-middle">
                {{ $achat->date_achat }}
              </td>
              <td class="align-middle">
                {{ $achat->status }}
              </td>
              <td class="align-middle">
                <span class="fw-bold text-uppercase">
                  {{ number_format($achat->ht , 2 , "," , " ") }} dh
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-uppercase">
                  {{ number_format($achat->ttc , 2 , "," , " ") }} dh
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-uppercase text-success">
                  {{ number_format($achat->payer , 2 , "," , " ") }} dh
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-uppercase text-danger">
                  {{ number_format($achat->reste , 2 , "," , " ") }} dh
                </span>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection