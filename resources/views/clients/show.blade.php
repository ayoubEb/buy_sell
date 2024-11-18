@extends('layouts.master')
@section('title')
  client : {{ $client->raison_sociale }}
@endsection
@section('content')
@include('sweetalert::alert')
<div class="card">
  <div class="card-body p-2">

    <div class="table-responsive">
      <table class="table table-bordered m-0">
        <thead class="table-primary">
          <tr>
            <th>montant devis</th>
            <th>montant facture</th>
            <th>payer</th>
            <th>reste</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="align-middle">
              <span class="mt fw-bold text-primary">
              {{ number_format($client->montant_devis , 2 , "," ," ") . ' dh' }}
            </span>
            </td>
            <td class="align-middle">
              <span class="mt fw-bold">
                {{ number_format($client->montant , 2 , "," ," ") . ' dh' }}
              </span>
            </td>
            <td class="align-middle">
              <span class="mt fw-bold text-success">
                {{ number_format($client->payer , 2 , "," ," ") . ' dh' }}
              </span>
            </td>
            <td class="align-middle">
              <span class="mt fw-bold text-danger">
              {{ number_format($client->reste , 2 , "," ," ") . ' dh' }}
            </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mt-4" role="tablist">
      <li class="nav-item">
        <a class="nav-link text-uppercase fw-bold  @if(!Session::has('valider')) active @endif" data-bs-toggle="tab" href="#infoFacture" role="tab">Information</a>
      </li>
      @can('facture-list')
      <li class="nav-item">
        <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#factures" role="tab">factures</a>
      </li>
      @endcan
      @can('facturePaiement-list')
      <li class="nav-item">
        <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#paiements" role="tab">paiements</a>
      </li>
      @endcan
      <li class="nav-item">
        <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#files" role="tab">documents</a>
      </li>
    </ul>

    <div class="tab-content">
      <div class="tab-pane p-0 pt-3 @if(!Session::has('valider')) active @endif" id="infoFacture" role="tabpanel">
        <div class="row row-cols-md-2 row-cols-1">
          <div class="col">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      identifiant
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->identifiant != '' ?
                        $client->identifiant : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      raison sociale
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->raison_sociale != '' ?
                        $client->raison_sociale : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ice
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->ice != '' ?
                        $client->ice : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      if
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->if != '' ?
                        $client->if : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      rc
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->rc != '' ?
                        $client->rc : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      téléphone
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->telephone != '' ?
                        $client->telephone : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      responsable
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->responsable != '' ?
                        $client->responsable : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      email
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->email != '' ?
                        $client->email : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      activite
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->activite != '' ?
                        $client->activite : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      adresse
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->adresse != '' ?
                        $client->adresse : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      ville
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->ville != '' ?
                        $client->ville : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      code postal
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->code_postal != '' ?
                        $client->code_postal : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      group
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->group &&
                        $client->group->nom  != '' ?
                        $client->group->nom : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      remise
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->group &&
                        $client->group->remise  != '' ?
                        $client->group->remise . "%" : '<i>aucun</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      type
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->type_client  != '' ?
                        $client->type_client : '<i>n / a</i>'
                      !!}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      max montant payé ( espèce )
                    </td>
                    <td class="align-middle">
                      {!!
                        $client->maxMontantPayer  != '' ?
                        number_format($client->maxMontantPayer , 2 , "," ," ") . " dh" : '<i>n / a</i>'
                      !!}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      @can('facture-list')
        <div class="tab-pane p-0 pt-3" id="factures" role="tabpanel">
          <div class="table-responsive">
            <table class="table table-bordered m-0 table-sm">
              <thead>
                <tr>
                  <th>référence</th>
                  <th>date</th>
                  <th>tva</th>
                  <th>remise</th>
                  <th>montant</th>
                  <th>ttc</th>
                  <th>net à payer</th>
                  <th>payer</th>
                  <th>reste</th>
                  <th>actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($factures as $facture)
                  <tr>
                    <td class="align-middle">
                      {{ $facture->num }}
                    </td>
                    <td class="align-middle">
                      {{ $facture->date_facture }}
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture->taux_tva , 2 , "," ," ") }} %
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture->remise , 2 , "," ," ") }} %
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture->ht , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="mt fw-bold">
                        {{ number_format($facture->ttc , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="text-primary mt fw-bold">
                        {{ number_format($facture->net_payer , 2 , "," ," ") }} dh
                      </span>
                    </td>

                    <td class="align-middle">
                      <span class="text-success mt fw-bold">
                        {{ number_format($facture->payer , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle">
                      <span class="text-danger mt fw-bold">
                        {{ number_format($facture->reste , 2 , "," ," ") }} dh
                      </span>
                    </td>
                    <td class="align-middle">
                      <a href="{{ route('facture.show',$facture) }}" class="btn btn-primary waves-effect waves-light p-0 px-2" target="_blank">
                        <span class="mdi mdi-eye-outline align-middle"></span>
                      </a>
                      @if ($facture->status == "validé")

                      <a href="{{ route('facture.show',$facture) }}" class="btn btn-dark waves-effect waves-light p-0 px-2">
                          <span class="mdi mdi-file-outline"></span>
                        </a>
                      @endif
                      @if ($facture->status == "validé" && isset($facture->adresse_livraison))
                        <a href="{{ route('facture.newPaiement',$facture) }}" class="btn btn-success waves-effect wave-light p-0 px-2">
                          <span class="mdi mdi-plus"></span>
                        </a>
                      @endif
                    </td>

                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endcan

      @can('facturePaiement-list')
      <div class="tab-pane p-0 pt-3" id="paiements" role="tabpanel">
        <div class="table-responsive">
          <table class="table table-bordered m-0 table-sm">
            <thead>
              <tr>
                <th>numéro opération</th>
                <th>facture</th>
                <th>date</th>
                <th>payer</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($paiements as $paiement)
                <tr>
                  <td class="align-middle">
                    {{ $paiement->numero_operation }}
                  </td>
                  <td class="align-middle">
                    {{ $paiement->facture->num }}
                  </td>
                  <td class="align-middle">
                    {{ $paiement->date_paiement }}
                  </td>
                  <td class="align-middle">
                    <span class="mt fw-bold">
                      {{ number_format($paiement->payer , 2 , "," ," ") }} dh
                    </span>
                  </td>

                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      @endcan

      <div class="tab-pane p-0 pt-3" id="files" role="tabpanel">
        <div class="table-responsive">
          <table class="table table-bordered table-customize">
            <thead>
              <tr>
                <th>nom</th>
                <th>file</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="align-middle">
                  rapport de client
                </td>
                <td class="align-middle">
                  <a href="{{ route('client.rapportDocument',$client) }}" class="btn btn-primary waves-effect waves-light p-0 px-2">
                    <span class="mdi mdi-file-outline"></span>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>




  </div>
</div>



@endsection