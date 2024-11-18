@extends('layouts.master')
@section('title')
Modifier le commande : {{ $commande->num ?? '' }}
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">Modifier le commande : {{ $commande->num ?? '' }}</h4>
    </div>
  </div>
</div>
<div class="d-flex justify-content-between mb-2">
  <a href="{{ route('ligneVente.index') }}" class="btn btn-brown waves-effect waves-light">
    retour
  </a>
  @canany(['ligneVente-modification', 'ligneVente-display'])
    <div class="">
      @can('ligneVente-display')
      <a href="{{ route('ligneVente.show',$commande) }}" class="btn btn-darkLight waves-effect waves-light">
        <span class="mdi mdi-eye-outline align-middle align-middle"></span>
        détails
      </a>
      @endcan
      @can('ligneVente-modification')
        <a href="{{ route('vente.add',$commande->id) }}" class="btn btn-darkLight waves-effect waves-light">
          <span class="mdi mdi-plus-thick align-middle align-middle"></span>
          <span>nouveau produits</span>
        </a>
        <button type="button" class="btn btn-vert waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#validation{{ $commande->id }}">
          <span class="mdi mdi-check-bold align-middle"></span>
          <span>validé le devis</span>
        </button>
        <div class="modal fade" id="validation{{ $commande->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body p-4">
                <form action="{{ route('ligneVente.valider',$commande) }}" method="post">
                  @csrf
                  @method("PUT")
                  <h5 class="text-primary mb-2 text-center">Valider la ligneVente séléctionner ?</h5>
                  <h6 class="text-danger mb-2 text-center">{{ $commande->num ?? '' }}</h6>
                  <h6 class="mb-3">Attention une fois validée , la ligneVente ne peux pas plus modifiables !</h6>
                  <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-vert waves-effect waves-light px-5 me-2">
                      Validé
                    </button>
                    <button type="button" class="btn btn-orange waves-effect waves-light px-5" data-bs-dismiss="modal" aria-label="btn-close">
                      Annuler
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      @endcan

    </div>

  @endcanany
</div>
<div class="row">
  <div class="col-lg-8">
    <h6 class="title">
      information basic
    </h6>
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('ligneVente.update',$commande) }}" method="POST">
          @csrf
          @method('PUT')
          <input type="hidden" id="ht" value="{{ $commande->ht }}">
          <div class="row row-cols-lg-2 row-cols-1">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Client</label>
                <select name="client" id="client" class="form-select">
                  <option value="">Séléctionner le client</option>
                  @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ $client->id == $commande->client_id ? "selected":"" }}>{{ $client->raison_sociale }}</option>
                  @endforeach
                </select>
              </div>
            </div>


            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Remise du group</label>
                <input type="number" name="remise" id="remiseCommande"  class="form-control" value="{{ $commande->remise ?? '' }}">
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Date du vente</label>
                <input type="date" name="dateCommande" id="" class="form-control" value="{{ $commande->dateCommande }}">
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Statut</label>
                <select name="statut" id="" class="form-select">
                  <option value="">Choisir le statut</option>
                  <option value="en cours" {{ $commande->statut == "en cours" ? "selected":"" }}>En cours</option>
                  <option value="validé" {{ $commande->statut == "validé" ? "selected":"" }}>Validé</option>
                  <option value="annuler" {{ $commande->statut == "annuler" ? "selected":"" }}>Annuler</option>
                </select>
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">TVA</label>
                <select name="tva" id="tva" class="form-select @error('tva') is-invalid @enderror">
                  <option value="">Choisir le tva</option>
                  @foreach ($tvas as $tva)
                    <option value = "{{ $tva }}" {{ $tva == $commande->taux_tva ? "selected" : "" }}> {{ $tva }} % </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-vert waves-effect waves-light px-5">mettre à jour</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col">
    <h6 class="title mb-2">
      paiements
    </h6>
    <div class="card">
      <div class="card-body p-2">
        <div class="table-reponsive">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">
                  prix ht
                </td>
                <td class="align-middle">
                  <span class="mt">
                    {{ number_format($commande->ht , 2 , "," ," ") . " dh" }}
                  </span>
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
                  prix ttc
                </td>
                <td class="align-middle">
                  <span class="mt">
                    {{ number_format($commande->ttc , 2 , "," ," ") . " dh" }}
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  net à payer
                </td>
                <td class="align-middle">
                  <span class="mt">
                    {{ number_format($commande->ttc , 2 , "," ," ") . " dh" }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <h6 class="title">
    </h6>
  </div>
</div>


<h6 class="title mb-2">
  les produits
</h6>
<div class="card" id="infoProduits">
  <div class="card-body p-2">
    <div @if(count($produits) > 10) style="height: 30rem;overflow-y:auto" @endif>
      <div class="table-resposnive">
        <table class="table table-bordered table-customize m-0">
          <thead class="table-success">
            <tr>
              <th>Référence</th>
              <th>Désignation</th>
              <th>Quantite</th>
              <th>Prix vente</th>
              <th>Remise</th>
              <th>Montant</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($produits as $vente)
              <tr>
                <td class="align-middle">{{ $vente->produit->reference  }}</td>
                <td class="align-middle">{{ $vente->produit->designation }}</td>
                <td class="align-middle">{{ $vente->quantite }}</td>
                <td class="align-middle">{{ $vente->prix }} DH</td>
                <td class="align-middle">{{ $vente->remise }} %</td>
                <td class="align-middle">{{ $vente->montant }} DH</td>
                <td class="align-middle">

                  <a href="{{ route('vente.edit',$vente) }}" class="btn btn-primary waves-effect waves-light py-1 px-2"">
                      <span class="mdi mdi-pencil"></span>
                  </a>

                  <button type="button" class="btn btn-danger waves-effect waves-light py-1 px-2" data-bs-toggle="modal" data-bs-target="#delete{{ $vente->id }}">
                      <span class="mdi mdi-trash-can"></span>
                  </button>
                  <div class="modal fade" id="delete{{ $vente->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body">
                          <form action="{{ route('vente.destroy',$vente) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                            <h6 class="mb-2 fw-bolder text-center text-muted">Voulez-vous supprimer défenitivement du produit</h6>
                            <h6 class="text-danger mb-2 text-center">{{ $vente->produit->reference }}</h6>

                            <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-action px-5 fw-bolder py-2 me-2">
                                  Je confirme
                              </button>
                              <button type="button" class="btn btn-fermer px-5 py-2 fw-bolder" data-bs-dismiss="modal" aria-label="btn-close">
                                  Annuler
                              </button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            @empty

            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>








@endsection
@section('script')
    <script>
        $(document).ready(function(){
          function calculation(){
          var remise     = $("#remiseCommande").val();
          var tva        = $("#tva").val();
          var ht         = $("#ht").val();
          var ht_tva     = parseFloat(ht * ( 1 + tva / 100)).toFixed(2);
          var remise_ht  = parseFloat(ht * (remise / 100)).toFixed(2);
          var remise_ttc = parseFloat(remise_ht * ( 1 + (tva / 100))).toFixed(2);
          var net_ttc    = parseFloat(ht_tva - remise_ttc).toFixed(2);
          $(".info tr:nth-child(1) td:nth-child(2)").html(parseFloat(ht).toFixed(2) + " dh");
          $(".info tr:nth-child(2) td:nth-child(2)").html(ht_tva + " dh");
          $(".info tr:nth-child(3) td:nth-child(2)").html(net_ttc + " dh");
          $(".info tr:nth-child(4) td:nth-child(2) span").html(net_ttc + " dh");
        }


      $("#tva").on("change",function(){
        calculation();
      })
      $("#remiseCommande").on("keyup",function(){
        calculation();
      })
        })
    </script>
@endsection