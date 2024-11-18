@extends('layouts.master')
  @section('title')
      Facture : {{ $commande->num }}
  @endsection
@section('content')
    <div class="card">
      <div class="card-body p-2">
        <div class="row row-cols-2 my-2">
          <div class="col">
            <div class="table-reponsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">ht</td>
                    <td class="align-middle">
                      {{ number_format($commande->ht , 2 , "," , " ") }} dh
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">ttc</td>
                    <td class="align-middle">
                      {{ number_format($commande->ttc , 2 , "," , " ") }} dh
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">remise</td>
                    <td class="align-middle">
                      {{ number_format($commande->remise , 2 , "," , " ") }} %
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="col">
            <div class="table-reponsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">net à payer</td>
                    <td class="align-middle">
                      {{ number_format($commande->net_payer , 2 , "," , " ") }} dh
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">payer</td>
                    <td class="align-middle">
                      {{ number_format($commande->payer , 2 , "," , " ") }} dh

                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">reste</td>
                    <td class="align-middle">
                      {{ number_format($commande->reste , 2 , "," , " ") }} dh

                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Nav tabs -->
        <ul class="nav nav-tabs mt-3" role="tablist">
          <li class="nav-item">
              <a class="nav-link @if(!Session::has('sup')) active @endif text-uppercase fw-bold" data-bs-toggle="tab" href="#infoFacture" role="tab">Information</a>
          </li>
          <li class="nav-item">
              <a class="nav-link" data-bs-toggle="tab" href="#produits" role="tab">produits</a>
          </li>

        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane @if(!Session::has('sup')) active @endif p-0 pt-3" id="infoFacture" role="tabpanel">
            <div class="row row-cols-md-2 row-cols-1">
              <div class="col mb-md-0 mb-2">
                <div class="table-responisve">
                  <table class="table table-bordered m-0 info">
                    <tbody>
                      <tr>
                        <td class="align-middle">
                          référence
                        </td>
                        <td class="align-middle">
                          {{$commande->num}}
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          entreprise
                        </td>
                        <td class="align-middle">
                          {{
                            $commande->entreprise &&
                            $commande->entreprise->raison_sociale != '' ?
                            $commande->entreprise->raison_sociale : ''
                          }}
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          client
                        </td>
                        <td class="align-middle">
                          {{
                            $commande->client &&
                            $commande->client->raison_sociale != '' ?
                            $commande->client->raison_sociale : ''
                          }}
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          identifiant client
                        </td>
                        <td class="align-middle">
                          {{
                            $commande->client &&
                            $commande->client->identifiant != '' ?
                            $commande->client->identifiant : ''
                          }}
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          date
                        </td>
                        <td class="align-middle">
                          {{ $commande->dateCommande}}
                        </td>
                      </tr>

                      <tr>
                        <td class="align-middle">
                          nombre produits
                        </td>
                        <td class="align-middle">
                          {{ $commande->nbrProduits}}
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
                          mois
                        </td>
                        <td class="align-middle">
                          {{ $commande->mois}}
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          HT TVA
                        </td>
                        <td class="align-middle">
                          <span class="mt">
                            {{ number_format($commande->ht_tva , 2 , "," ," ") . " dh" }}
                          </span>
                        </td>
                      </tr>

                      <tr>
                        <td class="align-middle">
                          <span class="text-primary">
                            net à crédit
                          </span>
                        </td>
                        <td class="align-middle">
                          <span class="mt text-primary fw-bold">
                            {{ number_format($commande->net_credit , 2 , "," ," ") . " dh" }}
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          statut
                        </td>
                        <td class="align-middle">
                          @if ($commande->statut == "validé")
                            <span class="text-success align-middle mdi mdi-check-bold"></span>
                            <span class="fw-bold text-success mt">
                              {{ $commande->statut }}
                            </span>
                          @elseif($commande->statut == "en cours")
                            <span class="text-warning align-middle mdi mdi-check-bold"></span>
                            <span class="fw-bold text-warning mt">
                              {{ $commande->statut }}
                            </span>
                            @else

                            <span class="text-danger align-middle mdi mdi-close"></span>
                            <span class="fw-bold text-danger mt">
                              {{ $commande->statut }}
                            </span>
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          date création
                        </td>
                        <td class="align-middle">
                          {{ $commande->dateCreation}}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane p-0 pt-3" id="produits" role="tabpanel">
            <div class="table-responsive">
              <table class="table table-striped table-sm m-0">
                <thead class="table-success">
                  <tr>
                    <th>référence</th>
                    <th>désignation</th>
                    <th>quantité</th>
                    <th>remise</th>
                    <th>prix vente</th>
                    <th>montant</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($produits as $commande_produit)
                    <tr>
                      <td class="align-middle">{{ $commande_produit->produit->reference ?? '' }} </td>
                      <td class="align-middle">{{ $commande_produit->produit->designation ?? '' }} </td>
                      <td class="align-middle">{{ $commande_produit->quantite ?? '' }}</td>
                      <td class="align-middle">
                        <span class="mt fw-bold">
                          {{ number_format($commande_produit->remise,2,","," ") }} %
                        </span>
                      </td>
                      <td class="align-middle">
                        <span class="mt fw-bold">
                          {{ number_format($commande_produit->prix,2,","," ") }} DH
                        </span>
                      </td>
                      <td class="align-middle">
                        <span class="mt fw-bold">
                          {{ number_format($commande_produit->montant,2,","," ") }} DH
                        </span>
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

@section('script')
<script>
    $(document).ready(function(){

    })
</script>
@endsection