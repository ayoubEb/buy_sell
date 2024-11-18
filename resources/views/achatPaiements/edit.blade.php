@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">modification paiement : {{ $achatPaiement->num }}</h4>
    </div>
  </div>
</div>
@include('ligneAchats.minInfo',[ "id"=>$ligneAchat->id ])
<h6 class="title mb-1">
  modification paiement
</h6>
<div class="card">
  <div class="card-body p-2">

    <form action="{{route('achatPaiement.update',$achatPaiement)}}" method="post">
      @csrf
      @method("PUT")
      <div class="row justify-content-center">


        <div class="col-lg-9 mb-2">
          <div class="form-group">
            <label for="" class="form-label">Montant payer</label>
            <input type="number" name="payer" id="" class="form-control payer  @error('payer') is-invalid @enderror" step="any" min="0" value="{{ $achatPaiement->payer }}" max="{{ $ligneAchat->reste +  $achatPaiement->payer }}">
            @error('payer')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
            <span id="error" class="text-danger"></span>
          </div>
        </div>
      </div>

      <div class="d-flex justify-content-between">
        <a href="{{ route('achatPaiement.index') }}" class="btn btn-retour waves-effect waves-light">
          <span>Retour</span>
        </a>
        <button type="submit" class="btn btn-vert waves-effect waves-light">
          <span>mettre à jour</span>
        </button>
      </div>
    </form>
  </div>
</div>
@endsection


@section('script')
    <script>
         $(document).ready(function(){
            $(".payer").on("keyup",function(){
                var payer = $(this).val();
                var reste_av = $("#reste_av").val();
                var resteNew = parseFloat(reste_av - payer).toFixed(2);
                $("#reste").val(resteNew);
                var resteN = $("#reste").val();
                if(resteN < 0)
                {
                  $("#reste").val(0);
                  $("#error").html("le montant à supérieur de ligne d'achat");
                }
                else
                {
                  $("#error").html("");

                }

            })
        })
    </script>
@endsection

