@extends('layouts.master')
@section('content')
@include('ligneCommandes.minInfo',['id'=>$commande->id])

<h6 class="title mb-1">
  modification paiement
</h6>
<div class="card">
  <div class="card-body p-2">
    <form action="{{route('ventePaiement.update',$ventePaiement)}}" method="post">
      @csrf
      @method("PUT")
      <div class="row row-cols-2">

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Montant payer</label>
            <input type="number" name="payer" id="" class="form-control payer  @error('payer') is-invalid @enderror" step="any" min="0" value="{{ $ventePaiement->payer }}" max="{{ $commande->reste +  $ventePaiement->payer }}">
            @error('payer')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
        </div>

        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-label">Montant reste nouveau</label>
            <input type="number" id="" step="any" class="form-control reste" value="" disabled>
          </div>
        </div>

      </div>
      <div class="d-flex justify-content-between">
        <a href="{{ route('ventePaiement.index') }}" class="btn btn-retour waves-effect waves-light">
          <span>Retour</span>
        </a>
        <button type="submit" class="btn btn-action waves-effect waves-light">
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
                $(".reste").val(reste_av - payer);

            })
        })
    </script>
@endsection

