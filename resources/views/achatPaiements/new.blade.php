@extends('layouts.master')
@section('title')
    nouveau paiementd'achat : {{ $ligneAchat->Num_achat }}
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">nouveau paiement d'achat : {{ $ligneAchat->num_achat }}</h4>
    </div>
  </div>
</div>
  @include('layouts.session')
  @include('ligneAchats.minInfo',[ "id"=>$ligneAchat->id ])
  <h6 class="title mb-1">
    nouveau paiement
  </h6>
  <div class="card">
    <div class="card-body p-2">
      @if ($ligneAchat->reste == 0)
        d
      @else
      <form action="{{ route('achatPaiement.store') }}" method="post">
        @csrf
        <input type="hidden" name="ligne_achat_id" value="{{ $ligneAchat->id }}">
        <input type="hidden" id="reste" value="{{ $ligneAchat->reste ?? '' }}">

        <div class="row row-cols-2">
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Type du paiement</label>
              <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">Choisir le type du paiement</option>
                <option value="espèce" {{ old('type') == 'espèce' || old('type') == null ? 'selected' : '' }} >Espèce</option>
              </select>
              @error('type')
                <strong class="invalid-feedback">
                  {{ $message }}
                </strong>
              @enderror
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Montant TTC</label>
              <input type="number" name="" id="ttc" class="form-control" value="{{ $ligneAchat->reste ?? '' }}" disabled>
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Montant payer</label>
              <input type="number" name="payer" id="payer" class="form-control" step="any" min="0" value="{{ old('payer') }}"
                max="{{ $ligneAchat->reste }}"
                disabled required
              >
              <span id="error" class="text-danger"></span>
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Montant reste nouveau</label>
              <input type="number" id="resteNew" step="any" class="form-control reste" value="" readonly>
            </div>
          </div>
        </div>




        <div class="d-flex justify-content-center mt-2">
          @can('achatPaiement-list')
            <a href="{{ route('ligneAchat.show',$ligneAchat) }}" class="btn btn-brown waves-effect waves-light me-5">
              liste
            </a>

          @endcan
          <button type="submit" class="btn btn-vert waves-effect waves-light">
            <span>Enregistrer</span>
          </button>
        </div>
      </form>
      @endif
    </div>
  </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
          var type = $("#type").val();
          if(type == 'chèque')
          {
            $("#cheque").show(450);
            $("#payer").prop("disabled",false);
          }
          else
          {
            $("#cheque").hide(450);
            $("#payer").prop("disabled",false);
          }

          var payer = $("#payer").val();
              var reste = $("#reste").val();
              var resteNew = parseFloat(reste - payer).toFixed(2);
              $("#resteNew").val(resteNew);


          $("#type").on("change", function() {
              let type = $(this).val();

              if (type == "chèque") {
                  $("#cheque").show(450);

              } else {
                  $("#cheque").hide(450);
              }


              if (type == "") {
                  $("#payer").prop("disabled", true);
              } else {
                  $("#payer").prop("disabled", false);

              }
          })
            $("#payer").on("keyup", function() {

              var payer = $(this).val();
              var reste = $("#reste").val();
              var resteNew = parseFloat(reste - payer).toFixed(2);
              $("#resteNew").val(resteNew);
              var resteN = $("#resteNew").val();
              if(resteN < 0)
              {
                $("#resteNew").val(0);
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
