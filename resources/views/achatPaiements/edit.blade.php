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

      <div class="row row-cols-2">
        <div class="col mb-2">
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
        <div class="col mb-2">
          <div class="form-group">
            <label for="" class="form-group">statut</label>
            <select name="statut" id="" class="form-select @error('statut') is-invalid @enderror">
              <option value="payé" {{ $achatPaiement->statut == "payé" ? "selected" : ""  }}>payé</option>
              <option value="en cours" {{ $achatPaiement->statut == "en cours" ? "selected" : ""  }}>en cours</option>
              <option value="impayé" {{ $achatPaiement->statut == "impayé" ? "selected" : ""  }}>impayé</option>
            </select>
            @error('statut')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
        </div>
        @if ($achatPaiement->type_paiement == "chèque")

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Numéro</label>
              <input type="text" name="numero_cheque" id="" class="form-control @error('numero_cheque') is-invalid @enderror" value="{{  $achatPaiement->cheque->numero }}">
              @error('numero_cheque')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Banque</label>
              <select name="banque_cheque" id="" class="form-select @error('banque_cheque') is-invalid @enderror">
                <option value=""></option>
                @foreach ($banques as $banque)
                  <option value="{{ $banque->id }}" {{ $achatPaiement->cheque->banque == $banque->nom ? "selected":"" }}> {{ $banque->nom }} </option>
                @endforeach
              </select>
              @error('banque_cheque')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Date</label>
              <input type="date" name="date_cheque" id="" class="form-control @error('date_cheque') is-invalid @enderror" value="{{ $achatPaiement->cheque && $achatPaiement->cheque->date_cheque != '' ? $achatPaiement->cheque->date_cheque : '' }}">
              @error('date_cheque')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Date enquisement</label>
              <input type="date" name="date_enquisement" id="" class="form-control @error('date_enquisement') is-invalid @enderror" value="{{ $achatPaiement->cheque && $achatPaiement->cheque->date_enquisement != '' ? $achatPaiement->cheque->date_enquisement : '' }}">
              @error('date_cheque')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>


          @endif
      </div>

      <div class="d-flex justify-content-between">
        <a href="{{ route('achatPaiement.index') }}" class="btn btn-brown waves-effect waves-light">
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

