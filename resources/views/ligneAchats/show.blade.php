@extends('layouts.master')
@section('title')
  Liste des achats
@endsection
@section('content')

<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">Achat : {{ $ligneAchat->num_achat }}</h4>
    </div>
  </div>
</div>
<div class="d-flex justify-content-between mt-md-0 mt-5">
  @can('ligneAchat-list')
    <a href="{{ route('ligneAchat.index') }}" class="btn btn-brown waves-effect waves-light">
      liste
    </a>
  @endcan
    <div class="">
      @if ($ligneAchat->status == "en cours")
      <a href="{{ route('achat.new',$ligneAchat) }}" class="btn btn-darkLight waves-effect waves-light" target="_blank">
        nouveau produit
      </a>
      @endif

    </div>
</div>


<div class="card">
  <div class="card-body p-2">
    @include('ligneAchats.resumeLigne',[ "id"=>$ligneAchat->id ])
    <ul class="nav nav-tabs nav-justified" role="tablist">
      <li class="nav-item">
          <a class="nav-link @if(!Session::has('sup')) active @endif text-uppercase fw-bold" data-bs-toggle="tab" href="#infoAchat"
              role="tab">Information</a>
      </li>
      <li class="nav-item">
          <a class="nav-link text-uppercase fw-bold" data-bs-toggle="tab" href="#produits" role="tab">produits</a>
      </li>
      <li class="nav-item">
          <a class="nav-link text-uppercase fw-bold @if(Session::has('sup')) active @endif" data-bs-toggle="tab" href="#paiements"
            role="tab">paiements</a>
      </li>

    </ul>

    <div class="tab-content">
      <div class="tab-pane @if(!Session::has('sup')) active @endif p-0 pt-3" id="infoAchat" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">
                      fournisseur
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->fournisseur &&
                        $ligneAchat->fournisseur->raison_sociale != '' ?
                        $ligneAchat->fournisseur->raison_sociale : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      entreprise
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->entreprise &&
                        $ligneAchat->entreprise->raison_sociale != '' ?
                        $ligneAchat->entreprise->raison_sociale : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      référence
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->num_achat != '' ?
                        $ligneAchat->num_achat : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      status
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->status != '' ?
                        $ligneAchat->status : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      taux_tva
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->taux_tva != '' ?
                        $ligneAchat->taux_tva . '%' : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      mois
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->mois != '' ?
                        $ligneAchat->mois : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      nombre d'achat
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->nombre_achats != '' ?
                        $ligneAchat->nombre_achats : ''
                      }}
                    </td>
                  </tr>

                  <tr>
                    <td class="align-middle">
                      mois
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->mois != '' ?
                        $ligneAchat->mois : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->date_achat != '' ?
                        $ligneAchat->date_achat : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      date création
                    </td>
                    <td class="align-middle">
                      {{
                        $ligneAchat->dateCreation != '' ?
                        $ligneAchat->dateCreation : ''
                      }}
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant ht
                    </td>
                    <td class="align-middle">
                      <span class="fw-bold">
                        {{ number_format($ligneAchat->ht , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant ttc
                    </td>
                    <td class="align-middle">
                      <span class="fw-bold">
                        {{ number_format($ligneAchat->ttc , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant à payé
                    </td>
                    <td class="align-middle">
                      <span class="fw-bold text-success">
                        {{ number_format($ligneAchat->payer , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">
                      montant à reste
                    </td>
                    <td class="align-middle">
                      <span class="fw-bold text-danger">
                        {{ number_format($ligneAchat->reste , 2 , "," , " ") }} dhs
                      </span>
                    </td>
                  </tr>

                </tbody>
              </table>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">

              </table>
            </div>
      </div>
      <div class="tab-pane p-0 pt-3" id="produits" role="tabpanel">
        <div class="table-resposnive">
          <table class="table table-bordered table-sm m-0">
            <thead class="table-success">
              <tr>
                <th>Référence</th>
                <th>Désignation</th>
                <th>Quantite</th>
                <th>Prix achat</th>
                <th>Remise</th>
                <th>Montant</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ligneAchat->achats as $achat)
                <tr>
                  <td class="align-middle">{{ $achat->produit->reference ?? '' }}</td>
                  <td class="align-middle">{{ $achat->produit->designation ?? '' }}</td>
                  <td class="align-middle">{{ $achat->quantite ?? '' }}</td>
                  <td class="align-middle">{{ $achat->prix ?? 0 }} DH</td>
                  <td class="align-middle">{{ $achat->remise ?? 0 }} %</td>
                  <td class="align-middle">{{ $achat->montant ?? 0 }} DH</td>

                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <div class="tab-pane p-0 pt-3 @if(Session::has('sup')) active @endif" id="paiements" role="tabpanel">
        @if ($ligneAchat->reste != 0 && $ligneAchat->status == "validé")
          @can('achatPaiement-nouveau')
            <a href="{{ route('achatPaiement.new',$ligneAchat) }}" class="btn btn-lien waves-effect waves-light mb-2" target="_blank">
              nouveau paiement
            </a>
          @endcan
       @endif
        <div class="table-resposnive">
          <table class="table table-bordered table-sm m-0">
            <thead class="table-success">
              <tr>
                <th>numéro opération</th>
                <th>type</th>
                <th>montant</th>
                <th>date</th>
                <th>status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($paiements as $paiement)
                <tr>
                  <td class="align-middle">{{ $paiement->numero_operation ?? '' }}</td>
                  <td class="align-middle">
                    @if ($paiement->type_paiement == "chèque")
                    <button type="button" class="btn btn-link waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#cheque{{ $paiement->id }}">
                      {{ $paiement->type_paiement ?? '' }}
                    </button>

                        <div class="modal fade" tabindex="-1" id="cheque{{ $paiement->id }}" role="dialog"
                        aria-labelledby="mySmallModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title mt-0">Center modal</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                              <ul class="list-group">
                                <li class="list-group-item">
                                  numéro : {{ $paiement->cheque->numero }}
                                </li>
                                <li class="list-group-item">
                                  banque : {{ $paiement->cheque->banque }}
                                </li>
                                <li class="list-group-item">
                                  date enquisement : {{ $paiement->cheque->date_enquisement }}
                                </li>
                                <li class="list-group-item">
                                  date chèque : {{ $paiement->cheque->date_cheque }}
                                </li>
                              </ul>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      @else
                      {{ $paiement->type_paiement ?? '' }}
                    @endif

                <!-- /.modal -->
                  </td>
                  <td class="align-middle">{{ $paiement->date_paiement ?? '' }}</td>
                  <td class="align-middle">{{ $paiement->payer ?? 0 }} DH</td>
                  <td class="align-middle">{{ $paiement->status ?? '' }}</td>

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
