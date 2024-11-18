@extends('layouts.master')
@section('title')

@endsection
@section('content')
@include('ligneCommandes.minInfo',["id"=>$vente->ligne_vente_id])
<div class="card">
  <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered info">
          <tbody>
            <tr>
              <td class="align-middle">ht</td>
              <td class="align-middle">
                <span id="htNew" class="mt">0.00 dh</span>
              </td>
            </tr>
            <tr>
              <td class="align-middle">ttc</td>
              <td class="align-middle">
                <span id="ttcNew" class="mt">0.00 dh</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  </div>
</div>
  <div class="card">
    <div class="card-body p-2">
      <input type="hidden" id="tva" value="{{ $vente->facture->taux_tva }}">
      <input type="hidden" id="price" value="{{ $vente->prix }}">
      <input type="hidden" id="htFacture" value="{{ $vente->facture->ht - $vente->montant }}">
          <form action="{{ route('vente.update',$vente) }}" method="post">
            @csrf
            @method("PUT")
            <div class="row row-cols-3">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">
                    quantite
                  </label>
                  <input type="number" name="quantite" id="qteValeur" min="1" max="{{ $stock->disponible }}" class="form-control @error('quantite') is-invalid @enderror" value="{{ $vente->quantite ?? 1 }}">
                  @error('quantite')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">
                    remise
                  </label>
                  <input type="number" name="remise" id="remiseValeur" min="0" step="any" class="form-control @error('remise') is-invalid @enderror" value="{{ $vente->remise ?? 0 }}">
                  @error('remise')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">
                    montant
                  </label>
                  <input type="number" id="mtValeur" min="0" step="any" class="form-control" value="{{ $vente->montant ?? 0 }}">
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between">
                <a href="{{ route('ligneVente.edit',$vente->facture) }}" class="btn btn-retour waves-effect waves-light">
                  retour
                </a>
              <button type="submit" class="btn btn-action waves-effect waves-light">
                mettre à jour
              </button>
            </div>
          </form>



    </div>
  </div>

@endsection



@section('script')
  <script>
    $(document).ready(function () {
      function calculation(){

        var qte = $("#qteValeur").val();
        var price = $("#price").val();
        var tva = $("#tva").val();
        var remise = $("#remiseValeur").val();
        var ht_avant = $("#htFacture").val();
        var mt = parseFloat(qte * price).toFixed(2);
        var ht     = parseFloat(mt * ( 1 - (remise/100))).toFixed(2);
        var ttc = parseFloat(ht  + (ht * (tva/100))).toFixed(2);
       $("#htNew").html(ht + ' dhs');
       $("#ttcNew").html(ttc) + ' dhs';
       $("#mtValeur").val(ht);

        // $("#ttc").html(ttc + ' dh');
      }


      $("#qteValeur").on("keyup",function(){
        calculation();

      })

      $("#remiseValeur").on("keyup",function(){
        calculation();
      })

    })
  </script>

@endsection