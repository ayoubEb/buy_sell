@extends('layouts.master')
@section('title')
    nouveau produit de vente : {{ $commande->num ?? '' }}
@endsection
@section('content')

<h6 class="title mb-2">
  <span>basic information</span>
</h6>
<div class="card">
  <div class="card-body p-2">
    <div class="row row-cols-2">
      <div class="col">
        <div class="table-reposnisve">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">
                  numéro
                </td>
                <td class="align-middle">
                  {{ $commande->num }}
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
                  ice
                </td>
                <td class="align-middle">
                  {{
                    $commande->client &&
                    $commande->client->ice != '' ?
                    $commande->client->ice : ''
                  }}
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
      <div class="col">
        <div class="table-reposnisve">
          <table class="table table-bordered m-0 info">
            <tbody>
              <tr>
                <td class="align-middle">
                  tva
                </td>
                <td class="align-middle">
                  {{ $commande->taux_tva }} %
                </td>
              </tr>

              <tr>
                <td class="align-middle">
                  prix ttc
                </td>
                <td class="align-middle">
                  <span class="mt fw-bold">
                    {{ number_format($commande->ttc , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>
              <tr>
                <td class="align-middle">
                  <span class="text-primary">
                    net à payer
                  </span>
                </td>
                <td class="align-middle">
                  <span class="mt fw-bold text-primary">
                    {{ number_format($commande->net_payer , 2 ,"," , " ") }} dhs
                  </span>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

    <h6 class="title mb-2">
      <span>paiement nouveau</span>
    </h6>
    <div class="card">
      <div class="card-body p-2">
        <div class="table-responsive">
          <table class="table table-bordered m-0 table-customize" id="pn">
            <thead>
              <tr>
                <th>montant ht (avant )</th>
                <th>remise</th>
                <th>montant ht</th>
                <th>ttc final</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="align-middle">
                  <span class="fw-bold text-uppercase">
                    {{ number_format($commande->ht,2,","," " ) . " dhs" }}
                  </span>
                </td>
                <td class="align-middle">
                  <span class="fw-bold text-uppercase">
                    {{ number_format($commande->remise,2,","," " ) . " %" }}
                  </span>
                </td>
                <td class="align-middle">
                  <span class="fw-bold text-uppercase">
                    0.00 dh
                  </span>
                </td>
                <td class="align-middle">
                  <span class="text-uppercase fw-bold text-primary">
                    0.00 dh
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>


{{-- @include('minInfo.commande',[ "id"=>$commande->id ]) --}}
<h6 class="title mb-2">
  <span>les produits</span>
</h6>
  <div class="card mb-0">
    <div class="card-body p-2" @if(count($produits) > 8) style="height: 27rem;overflow-y:auto;" @endif>
      <form action="{{ route('vente.store') }}" method="post">
        @csrf

            <input type="hidden" name="commande_id" value="{{ $commande->id }}">
            <input type="hidden" id="tva" value="{{ $commande->taux_tva }}">
            <input type="hidden" id="remiseCommande" value="{{ $commande->remise }}">
            <input type="hidden" id="ht_previous" value="{{ $commande->ht }}">
            <div class="table-responsive">
              <table class="table table-customize table-bordered m-0">
                <thead class="table-success">
                  <tr>
                    <th class="col-2">référence</th>
                    <th>nom</th>
                    <th class="col-1">prix</th>
                    <th class="col-1">quantité</th>
                    <th class="col-1">remise</th>
                    <th class="col-2">montant</th>
                    <th class="col-1">réserver</th>
                    <th class="col-1">disponible</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($produits as $k => $produit)
                    <tr>
                      <td class="align-middle">
                        <div class="form-check fs-12">
                          <input type="checkbox" name="pro[]" id="p{{$produit->id}}" class="form-check-input pro" value="{{ $produit->id }}">
                          <label for="p{{$produit->id}}" class="form-check-label">{{ $produit->reference }}</label>
                        </div>
                      </td>
                      <td class="align-middle fs-12">{{ $produit->designation }}</td>
                      <td class="align-middle">
                        <input type="number" name="price[]" id="" class="form-control form-control-sm price" value="{{ $produit->prix_vente }}">
                      </td>
                      <td class="align-middle">
                        <input type="number" name="qte[]" step="any" min="1"  id="" max="{{ $produit->disponible }}" class="form-control form-control-sm qte" value="0" disabled>
                      </td>
                      <td class="align-middle">
                        <input type="number" name="remise[]" step="any" max="100" min="0" disabled id="" class="form-control form-control-sm remise" value="0">
                      </td>
                      <td class="align-middle">
                          <input type="number" step="any"  id="" class="form-control form-control-sm montant" value="0" readonly>
                      </td>
                      <td class="align-middle">
                          <h6 class="m-0">{{ $produit->qte_venteRes }}</h6>
                      </td>
                      <td class="align-middle">
                          <h6 class="m-0">{{ $produit->disponible - $produit->qte_venteRes }}</h6>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>


          <div class="row justify-content-center">
            <div class="col-lg-8">
              <div class="d-flex justify-content-between mt-2">
                <a href="{{ route('ligneVente.edit',$commande) }}" class="btn btn-brown waves-effect waves-light">
                  retour
                </a>
                <button type="submit" class="btn btn-vert waves-effect waves-light">
                  <span>Enregistrer</span>
                </button>
              </div>

            </div>
          </div>

      </form>
    </div>
  </div>

  @endsection

  @section('script')
  <script>
    $(document).ready(function () {
      function calculationMontant(e){
        var qte           = $(e.target).parent().parent().children("td").children(".qte").val();
        var price         = $(e.target).parent().parent().children("td").children(".price").val();
        var remiseProduit = $(e.target).parent().parent().children("td").children(".remise").val();
        var montant       = parseFloat(qte * price).toFixed(2);
        var ht            = parseFloat(montant * ( 1 - (remiseProduit/100))).toFixed(2)
        $(e.target).parent().parent().children("td").children(".montant").val(ht);
      }
      function calculation(){
        var remise = $("#remiseCommande").val();
        var tva = $("#tva").val();
        var ht = parseFloat($("#ht_previous").val());
        $('.montant').each(function() {
          var value = parseFloat($(this).val()) || 0;
          ht += value;
        });
        var ht_tva = parseFloat(ht * ( 1 + tva / 100)).toFixed(2);
        var remise_ht = parseFloat(ht * (remise / 100)).toFixed(2);
        var remise_ttc = parseFloat(remise_ht * ( 1 + (tva / 100))).toFixed(2);
        var net_ttc = parseFloat(ht_tva - remise_ttc).toFixed(2);
        // $("table:nth-child(3) tbody tr td:nth-child(1)").html(parseFloat(ht).toFixed(2) + " dh");
        $("table").eq(2).find("tbody tr td:nth-child(3) span").html(parseFloat(ht).toFixed(2) + " dh");
        $("table").eq(2).find("tbody tr td:nth-child(4) span").html(net_ttc + " dh");

        // $(".info tr:nth-child(2) td:nth-child(2)").html(ht_tva + " dh");
        // $(".info tr:nth-child(3) td:nth-child(2)").html(net_ttc + " dh");
        // $(".info tr:nth-child(4) td:nth-child(2) span").html(net_ttc + " dh");
      }





      $(document).on("change",".pro",function(e){
        var sum = 0;
        if($(this).is(':checked'))
        {
          $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",false);
          $(e.target).parent().parent().parent().addClass("table-primary");
          $(e.target).parent().parent().parent().children('td').children(".montant").prop("disabled",false);
          $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",false);
          $(e.target).parent().parent().parent().children('td').children(".qte").val(1);
        }
        else
        {
          $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".montant").prop("disabled",true);
          $(e.target).parent().parent().parent().removeClass("table-primary");
          $(e.target).parent().parent().parent().children('td').children(".montant").val();
          $(e.target).parent().parent().parent().children('td').children(".qte").val(0);
        }
        $(e.target).parent().parent().parent().children('td').children(".remise").val(0);
        var count_pro = $(".pro:checked").length;
        var qte       = $(e.target).parent().parent().parent().children('td').children(".qte").val();
        var price     = $(e.target).parent().parent().parent().children('td').children(".price").val();
        var remise    = $(e.target).parent().parent().parent().children('td').children(".remise").val();
        var montant   = parseFloat(qte * price).toFixed(2);
        var ht_total  = parseFloat(montant * ( 1 - (remise/100))).toFixed(2);
        $(e.target).parent().parent().parent().children('td').children(".montant").val(ht_total);
        calculation();
      })


      $(".qte , .remise , .price").on("keyup",function(e){
        calculationMontant(e);
        calculation();
      })







    })
  </script>

@endsection