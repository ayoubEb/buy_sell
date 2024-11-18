@extends('layouts.master')
@section('title')
    Liste des paiement du factures
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb mb-1">
        <li class="breadcrumb-item">
            <a href="{{ route('home') }}">Acceuil</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">
            Liste des paiement du factures

        </li>
    </ol>
</nav>

<div class="card">
    <div class="card-body p-2">
        <div class="table-responsive">
            <table class="table table-bordered table-sm m-0">
                <thead>
                    <tr>
                        <th>facture</th>
                        <th>client</th>
                        <th>type</th>
                        <th>montant payer</th>
                        <th>montant reste</th>
                        <th>date</th>
                    </tr>
                    <tbody>
                        @foreach ($facturePaiements as $paiement)
                        <tr>
                            <td class="align-middle"> {{ $paiement->facture->num ?? '' }} </td>
                                <td class="align-middle"> {{ $paiement->client->raison_sociale ?? '' }} </td>
                                <td class="align-middle">
                                    @if ($paiement->type_paiement == "chèque")
                                        <button type="button" class="btn btn-link p-0 shadow-none fw-bolder text-decoration-none" data-bs-toggle="modal" data-bs-target="#cheque{{ $paiement->id }}">
                                            {{ $paiement->type_paiement ?? '' }}
                                        </button>
                                    @else
                                        {{ $paiement->type_paiement ?? '' }}
                                    @endif
                                </td>
                                <td class="align-middle text-success fw-bolder"> {{ $paiement->payer ?? 0 }} DH </td>
                                <td class="align-middle text-danger fw-bolder"> {{ $paiement->reste ?? 0 }} DH</td>
                                <td class="align-middle"> {{ $paiement->date_paiement ?? '' }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                </thead>
            </table>
        </div>
    </div>
</div>
@foreach ($paiementCheques as $paiementCheque)
    {{-- @if (isset($paiement->cheque)) --}}
    <div class="modal fade" id="cheque{{ $paiementCheque->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header py-3 bg-dark">
                    <h6 class="modal-title m-0 text-uppercase text-white" id="varyingModalLabel">Paiement chèque</h6>
                    <button type="button" class="btn btn-transparent p-0 border-0 shadow-none" data-bs-dismiss="modal" aria-label="btn-close">
                        <span class="mdi mdi-close-thick"></span>
                    </button>
                </div>
                <div class="modal-body">
                   <ul class="list-group">
                    <li class="list-group-item py-2 active text-center text-uppercase fw-bolder fs-12">numéro</li>
                    <li class="list-group-item py-2 text-center">{{ $paiementCheque->cheque->numero ?? '' }}</li>
                    <li class="list-group-item py-2 active text-center text-uppercase fw-bolder fs-12">bank</li>
                    <li class="list-group-item py-2 text-center">{{ $paiementCheque->cheque->bank->nom_bank ?? '' }}</li>
                    <li class="list-group-item py-2 active text-center text-uppercase fw-bolder fs-12">date</li>
                    <li class="list-group-item py-2 text-center">{{ $paiementCheque->cheque->date_cheque ?? '' }}</li>
                    <li class="list-group-item py-2 active text-center text-uppercase fw-bolder fs-12">date enquisement</li>
                    <li class="list-group-item py-2 text-center">{{ $paiementCheque->cheque->date_enquisement ?? '' }}</li>
                   </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- @endif --}}
@endforeach
@endsection