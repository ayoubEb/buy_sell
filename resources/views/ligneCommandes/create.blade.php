  @extends('layouts.master')
  @section('title')
      Ajouter de facture
  @endsection
  @section('content')


  <form action="{{ route('ligneVente.store') }}" method="post">
    @csrf
    <div class="row">
      <div class="col-lg-7">
        <h6 class="title mb-1">
          <span>basic information</span>
        </h6>
        <div class="card">
          <div class="card-body p-2">
            <div class="row row-cols-md-2 row-cols-1">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Client</label>
                  <select name="client" id="client" class="form-select @error('client') is-invalid @enderror" required>
                    <option value="">Choisir le client</option>
                    @forelse ($clients as $client)
                      <option value="{{$client->id}}" {{ old("client") == $client->id ? "selected": "" }} >{{ $client->raison_sociale }}</option>
                    @empty
                      <option value="">Aucun client exsite</option>
                    @endforelse
                  </select>
                  @error('client')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Remise ( % )</label>
                  <input type="number" name="remise_facture" min="0" id="remiseCommande" class="form-control @error('remise_facture') is-invalid @enderror" value="{{ old('remise_facture') == '' ? 0 : old('remise_facture') }}">
                  @error('remise_facture')
                    <strong class="invalid-feedback"> {{ $message }} </strong>
                  @enderror
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Statut</label>
                  <select name="statut" id="" class="form-select">
                    <option value=""> -- choisir le statut -- </option>
                    <option value="en cours" {{ old("statut") == null || old("statut") == "en cours" ? "selected":"" }}>en cours</option>
                    <option value="validé" {{ old("statut") == "validé" ? "selected":"" }}>validé</option>
                  </select>
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">date</label>
                  <input type="date" id="" name="date_facture" class="form-control" value="{{ old('date_facture') == null ? date("Y-m-d") : old('date_facture') }}">
                </div>
              </div>


              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Entreprise</label>
                  <select name="entreprise_id" id="" class="form-select @error('entreprise_id') is-invalid @enderror">
                    <option value="">Séléctionner l'entreprise</option>
                    @foreach ($entreprises as $entreprise)
                        <option value="{{ $entreprise->id }}"  @if(count($entreprises)==1) selected @endif>{{ $entreprise->raison_sociale }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">TVA</label>
                  <select name="tva" id="tva" class="form-select @error('tva') is-invalid @enderror" required>
                    <option value="">Choisir le tva</option>
                    @foreach ($tvas as $tva)
                      <option value="{{ $tva }}" {{ $tva == old("tva") || $tva == 20 ? "selected" : "" }}> {{ $tva }} % </option>
                    @endforeach
                  </select>
                  @error('tva')
                    <strong class="invalid-feedback"> {{ $message }} </strong>
                  @enderror
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <h6 class="title mb-1">
          <span>
            paiements
          </span>
        </h6>
        <div class="card">
          <div class="card-body p-2">
            <div class="table-responsive">
              <table class="table table-bordered m-0 info">
                <tbody>
                  <tr>
                    <td class="align-middle">ht</td>
                    <td class="align-middle">
                      0.00 dh
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">ht tva</td>
                    <td class="align-middle">
                      0.00 dh
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">ttc</td>
                    <td class="align-middle">
                      0.00 dh
                    </td>
                  </tr>
                  <tr>
                    <td class="align-middle">net à payer</td>
                    <td class="align-middle">
                      <span class="text-primary mt">
                        0.00 dh
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
    <h6 class="title mb-1">
      <span>les produits</span>
    </h6>
    <div class="card m-0">
      <div class="card-body p-2">
          <div @if (count($produits) >= 100) style="height: 30rem;  overflow-y: auto;" @endif >
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
          </div>
          <div class="d-flex justify-content-between mt-3">
            <a href="{{ url()->previous() }}" class="btn btn-orange waves-effect waves-light">
              retour
            </a>
            <button type="submit" class="btn btn-vert waves-effect waves-light">
              Enregistrer
            </button>
          </div>
        </div>
      </div>
    </form>


  <style>
      /* #nouveau{
          display: none;
      } */
  </style>
  @endsection
  @section('script')
  <script>
    $(document).ready(function(){
      function calculationMontant(e){
        var qte         = $(e.target).parent().parent().children("td").children(".qte").val();
        var price         = $(e.target).parent().parent().children("td").children(".price").val();
        var remiseProduit = $(e.target).parent().parent().children("td").children(".remise").val();
        var montant       = parseFloat(qte * price).toFixed(2);
        var ht            = parseFloat(montant * ( 1 - (remiseProduit/100))).toFixed(2)
        $(e.target).parent().parent().children("td").children(".montant").val(ht);
      }
      function calculation(){
        var remise = $("#remiseCommande").val();
        var tva = $("#tva").val();
        var ht = 0;
        $('.montant').each(function() {
          var value = parseFloat($(this).val()) || 0;
          ht += value;
        });
        var ht_tva = parseFloat(ht * ( 1 + tva / 100)).toFixed(2);
        var remise_ht = parseFloat(ht * (remise / 100)).toFixed(2);
        var remise_ttc = parseFloat(remise_ht * ( 1 + (tva / 100))).toFixed(2);
        var net_ttc = parseFloat(ht_tva - remise_ttc).toFixed(2);
        $(".info tr:nth-child(1) td:nth-child(2)").html(parseFloat(ht).toFixed(2) + " dh");
        $(".info tr:nth-child(2) td:nth-child(2)").html(ht_tva + " dh");
        $(".info tr:nth-child(3) td:nth-child(2)").html(net_ttc + " dh");
        $(".info tr:nth-child(4) td:nth-child(2) span").html(net_ttc + " dh");
      }










      $(document).on("change",".pro",function(e){
        var sum = 0;
        if($(this).is(':checked'))
        {
          $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",false);
          $(e.target).parent().parent().parent().addClass("table-success");
          $(e.target).parent().parent().parent().children('td').children(".montant").prop("disabled",false);
          $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",false);
          $(e.target).parent().parent().parent().children('td').children(".qte").val(1);
        }
        else
        {
          $(e.target).parent().parent().parent().children('td').children(".qte").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".remise").prop("disabled",true);
          $(e.target).parent().parent().parent().children('td').children(".montant").prop("disabled",true);
          $(e.target).parent().parent().parent().removeClass("table-success");
          $(e.target).parent().parent().parent().children('td').children(".montant").val();
          $(e.target).parent().parent().parent().children('td').children(".qte").val(0);
        }
        $(e.target).parent().parent().parent().children('td').children(".remise").val(0);
        var count_pro = $(".pro:checked").length;
        var qte            = $(e.target).parent().parent().parent().children('td').children(".qte").val();
        var price          = $(e.target).parent().parent().parent().children('td').children(".price").val();
        var remise         = $(e.target).parent().parent().parent().children('td').children(".remise").val();
        var montant        = parseFloat(qte * price).toFixed(2);
        var ht_total  = parseFloat(montant * ( 1 - (remise/100))).toFixed(2);
        $(e.target).parent().parent().parent().children('td').children(".montant").val(ht_total);
        calculation();
      })


      $(".qte , .remise , .price").on("keyup",function(e){
        calculationMontant(e);
        calculation();
      })





      $("#tva").on("change",function(){
        calculation();
      })
      $("#remiseCommande").on("keyup",function(){
        calculation();
      })



    });




    </script>
  @endsection