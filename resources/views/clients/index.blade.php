@extends('layouts.master')
@section('title')
    Liste des clients
@endsection
@section('content')
@include('sweetalert::alert')
<div class="card">
  <div class="card-body p-2">
    @can('client-nouveau')
    <a href="{{ route('client.create') }}" class="btn btn-lien waves-effect waves-light mb-2">
      <span>Nouveau</span>
    </a>
    @endcan
    <div class="table-responsive">
      <table class="table table-bordered m-0 table-sm" id="dt">
        <thead class="table-success">
          <tr>
            <th>#id</th>
            <th>raison sociale</th>
            <th>identifiant</th>
            <th>adresse</th>
            <th>Téléphone</th>
            <th>remise</th>
            <th>type</th>
            <th>montant devis</th>
            <th>montant</th>
            <th>payer</th>
            <th>reste</th>
            @canany(['client-display', 'client-modification-', 'client-suppression'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($clients as $client)
            <tr>
              <td class="align-middle">
                {!!
                  "#" . $client->id
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $client->raison_sociale ?? '<span class="text-muted text-uppercase">n / a</span>'
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $client->identifiant ?? '<span class="text-muted text-uppercase">n / a</span>'
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $client->adresse ?? '<span class="text-muted text-uppercase">n / a</span>'
                !!}
              </td>
              <td class="align-middle">
                {!!
                  $client->telephone ?? '<span class="text-muted text-uppercase">n / a</span>'
                !!}
              </td>
              <td class="align-middle">
                {{
                  $client->group &&
                  $client->group->remise != '' ?
                  number_format($client->group->remise , 2 , ',' ,' ') . " %" : '0'
                }}
              </td>
              <td class="align-middle">
                {!!
                  $client->type_client ?? '<span class="text-muted text-uppercase">n / a</span>'
                !!}
              </td>
              <td class="align-middle">
                <span class="fw-bold mt">
                  {{ number_format($client->montant_devis , 2 , "," ," ") }} dh
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold mt">
                  {{ number_format($client->montant , 2 , "," ," ") }} dh
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-success mt">
                  {{ number_format($client->payer , 2 , "," ," ") }} dh
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-danger mt">
                  {{ number_format($client->reste , 2 , "," ," ") }} dh
                </span>
              </td>
              @can('client-modification')
              <td class="align-middle">
                    <a href="{{ route('client.edit',$client->id) }}" class="btn btn-primary waves-effect waves-light p-0 px-2">
                      <span class="mdi mdi-pencil-outline align-middle"></span>
                    </a>
                  @endcan
                  @can('client-display')
                    <a href="{{ route('client.show',$client->id) }}" class="btn btn-warning waves-effect waves-light p-0 px-2">
                      <span class="mdi mdi-eye-outline align-middle"></span>
                    </a>
                  @endcan
                  @can('client-suppression')
                    <button  class="btn btn-danger waves-effect waves-light p-0 px-2" data-bs-toggle="modal" data-bs-target="#delete{{$client->id}}">
                      <span class="mdi mdi-trash-can"></span>
                    </button>
                    <div class="modal fade" id="delete{{ $client->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header py-2">
                            <h6 class="modal-title m-0" id="exampleModalCenterTitle">Confirmer la suppression</h6>
                            <button type="button" class="btn bg-transparent p-0 border-0" data-bs-dismiss="modal" aria-label="Close">
                              <span class="mdi mdi-close-thick"></span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form action="{{ route('client.destroy',$client) }}" method="post">
                              @csrf
                              @method("DELETE")
                              <h6 class="mb-2 text-center text-muted">
                                Voulez-vous vraiment déplacer du client vers la corbeille
                              </h6>
                              <h6 class="text-center mb-2 text-danger text-uppercase">
                                {{ $client->raison_sociale ?? '' }}
                              </h6>
                              <div class="row justify-content-center">
                                <div class="col-lg-5">
                                  <button type="submit" class="btn btn-success btn-sm w-100">OUI</button>
                                </div>
                                <div class="col-lg-5">
                                  <button type="button" class="btn btn-danger btn-sm w-100" data-bs-dismiss="modal" aria-label="Close">
                                    NON
                                  </button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </td>
                  @endcan
            </tr>
          @empty

          @endforelse
        </tbody>
    </table>
</div>





    </div>
</div>


{{--
@foreach ($clients as $client)

<div class="modal fade" id="show{{ $client->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-2">
                <h6 class="modal-title m-0 text-white" id="varyingModalLabel">Client : {{ $client->raison_sociale }}</h6>
                <button type="button" class="btn btn-transparent p-0 border-0 text-white" data-bs-dismiss="modal" aria-label="btn-close">
                    <span class="mdi mdi-close-thick"></span>
                </button>
            </div>
            <div class="modal-body">

                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#general{{ $client->id }}" role="tab">
                            Information général
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#facture{{ $client->id }}" role="tab">Facture</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#produit{{ $client->id }}" role="tab">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#paiement{{ $client->id }}" role="tab">Paiements</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active p-1" id="general{{ $client->id }}" role="tabpanel">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <img src="{{ asset('images/user.png') }}" alt="" class="img-fluid mb-2">
                                        <table class="table table-borderless m-0 table-sm">
                                            <tbody>
                                                <tr>
                                                    <th class="col-lg-5">raison sociale</th>
                                                    <td> {{ $client->raison_sociale ?? '' }} </td>
                                                </tr>
                                                <tr>
                                                    <th class="col-lg-5">type client</th>
                                                    <td> {{ $client->type->nom ?? '' }} </td>
                                                </tr>
                                                <tr>
                                                    <th class="col-lg-5">group</th>
                                                    <td> {{ $client->group->nom ?? '' }} </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card">
                                    <div class="card-body p-2">
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-sm m-0">
                                                <tbody>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">raison sociale</th>
                                                        <td class=""> {{ $client->raison_sociale ?? '' }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">group</th>
                                                        <td> {{ $client->group->nom ?? '' }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">remise</th>
                                                        <td> {{ $client->group->remise ?? '' }} %</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">responsable</th>
                                                        <td> {{ $client->responsable ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">ice</th>
                                                        <td> {{ $client->ice ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">if</th>
                                                        <td> {{ $client->if ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">rc</th>
                                                        <td> {{ $client->rc ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">télélphone</th>
                                                        <td> {{ $client->telephone ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">activité</th>
                                                        <td> {{ $client->activite ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">adresse</th>
                                                        <td> {{ $client->adresse ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">ville</th>
                                                        <td> {{ $client->ville ?? '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="col-lg-3 fw-bolder">code postal</th>
                                                        <td> {{ $client->code_postal ?? '' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane py-2 p-1" id="facture{{ $client->id }}" role="tabpanel">
                        <div class="card m-0">
                            <div class="card-body p-2">
                                <div class="row justify-content-center mb-2">
                                    <div class="col-lg-6">
                                        <table class="table table-bordered table-sm m-0">
                                            <thead class="bg-secondary">
                                                <tr>
                                                    <th class="text-white text-center">total</th>
                                                    <th class="text-white text-center">total payer</th>
                                                    <th class="text-white text-center">total reste</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td class="align-middle text-uppercase fw-bolder text-center text-dark"> {{ $client->factures()->sum("prix_ttc") }} dh </td>
                                                <td class="align-middle text-uppercase fw-bolder text-center text-success"> {{ $client->factures()->sum("payer") }} dh </td>
                                                <td class="align-middle text-uppercase fw-bolder text-center text-danger"> {{ $client->factures()->sum("reste") }} dh </td>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm m-0">
                                        <thead class="table-success">
                                            <tr>
                                                <th>référence</th>
                                                <th>ttc</th>
                                                <th>payer</th>
                                                <th>reste</th>
                                                <th>statut</th>
                                                <th>paiement</th>
                                                <th>date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($client->factures as $facture)
                                                <tr>
                                                    <td class="align-middle fs-12"> {{ $facture->num ?? '' }} </td>
                                                    <td class="align-middle fs-12 fw-bolder"> {{ $facture->prix_ttc ?? '' }} DH</td>
                                                    <td class="align-middle fs-12 text-success fw-bolder"> {{ $facture->payer ?? '' }} DH</td>
                                                    <td class="align-middle fs-12 text-danger fw-bolder"> {{ $facture->reste ?? '' }} DH</td>
                                                    <td class="align-middle fs-12 text-danger fw-bolder">
                                                        <span class="badge {{ $facture->statut == "validé" ? "bg-success":"bg-danger" }}"> {{ $facture->statut ?? '' }} </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="badge {{ $facture->etat_paiement == "attente" ? "bg-danger":"bg-success" }}"> {{ $facture->etat_paiement ?? '' }} </span>
                                                    </td>
                                                    <td class="align-middle fs-12"> {{ $facture->date ?? '' }} DH</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane py-2 p-1" id="produit{{ $client->id }}" role="tabpanel">
                        <div class="card m-0">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm m-0">
                                        <tbody>
                                            @foreach ($client->factures as $facture)
                                                <tr class="table-success">
                                                    <th colspan="6" class="text-center"> {{$facture->num ?? ''}} </th>
                                                </tr>
                                                <tr class="table-warning">
                                                    <th>référence</th>
                                                    <th>désignation</th>
                                                    <th>prix</th>
                                                    <th>quantite</th>
                                                    <th>montant</th>
                                                    <th>remise</th>
                                                </tr>
                                                @foreach ($facture->produits as $facture_pro)
                                                    <tr>
                                                        <td class="align-middle"> {{ $facture_pro->produit->reference ?? '' }} </td>
                                                        <td class="align-middle"> {{ $facture_pro->produit->designation ?? '' }} </td>
                                                        <td class="align-middle"> {{ $facture_pro->produit->prix_vente ?? '' }} DH</td>
                                                        <td class="align-middle"> {{ $facture_pro->quantite ?? '' }}</td>
                                                        <td class="align-middle"> {{ $facture_pro->montant ?? '' }} DH</td>
                                                        <td class="align-middle"> {{ $facture_pro->remise ?? '' }} %</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane py-2 p-1" id="paiement{{ $client->id }}" role="tabpanel">
                        <div class="card m-0">
                            <div class="card-body p-2">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm m-0">
                                        <thead class="table-success">
                                            <tr>
                                                <th>type</th>
                                                <th>payer</th>
                                                <th>reste</th>
                                                <th>date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($client->paiements as $paiement)
                                                <tr>
                                                    <td class="align-middle fs-12"> {{ $paiement->type_paiement ?? '' }} </td>
                                                    <td class="align-middle fs-12 fw-bolder"> {{ $facture->prix_ttc ?? '' }} DH</td>
                                                    <td class="align-middle fs-12 text-success fw-bolder"> {{ $paiement->payer ?? '' }} DH</td>
                                                    <td class="align-middle fs-12 text-danger fw-bolder"> {{ $facture->reste ?? '' }} DH</td>
                                                    <td class="align-middle fs-12"> {{ $paiement->date ?? '' }} DH</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td class="align-middle" colspan="5">
                                                        <h6 class="m-0 text-uppercase text-center text-danger fs-12 py-2">aucun paiement</h6>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endforeach --}}


@endsection
@section('script')
<script>
 $(document).ready(function() {
    $('#dt').DataTable({
        "columnDefs": [
            {
                "targets": 0, // Assuming the ID column is the first column (index 0)
                "type": "num" // Forces numeric sorting
            }
        ]
    });
});

</script>
@endsection
