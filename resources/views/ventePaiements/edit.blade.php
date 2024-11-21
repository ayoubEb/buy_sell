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
            <label for="" class="form-group">statut</label>
            <select name="statut" id="" class="form-select @error('statut') is-invalid @enderror">
              <option value="payé" {{ $ventePaiement->statut == "payé" ? "selected" : ""  }}>payé</option>
              <option value="en cours" {{ $ventePaiement->statut == "en cours" ? "selected" : ""  }}>en cours</option>
              <option value="impayé" {{ $ventePaiement->statut == "impayé" ? "selected" : ""  }}>impayé</option>
            </select>
            @error('statut')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
        </div>
        @if ($ventePaiement->type_paiement == "chèque")

          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-group">Numéro</label>
              <input type="text" name="numero_cheque" id="" class="form-control @error('numero_cheque') is-invalid @enderror" value="{{  $ventePaiement->cheque->numero }}">
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
                  <option value="{{ $banque->id }}" {{ $ventePaiement->cheque->banque == $banque->nom ? "selected":"" }}> {{ $banque->nom }} </option>
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
              <input type="date" name="date_cheque" id="" class="form-control @error('date_cheque') is-invalid @enderror" value="{{ $ventePaiement->cheque && $ventePaiement->cheque->date_cheque != '' ? $ventePaiement->cheque->date_cheque : '' }}">
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
              <input type="date" name="date_enquisement" id="" class="form-control @error('date_enquisement') is-invalid @enderror" value="{{ $ventePaiement->cheque && $ventePaiement->cheque->date_enquisement != '' ? $ventePaiement->cheque->date_enquisement : '' }}">
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

