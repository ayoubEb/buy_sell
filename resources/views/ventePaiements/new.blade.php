@extends('layouts.master')
@section('content')
@include('ligneCommandes.minInfo',['id'=>$commande->id])
<h6 class="title mb-1">
  nouveau paiement
</h6>
  <div class="card">
    <div class="card-body p-2">
      <form action="{{ route('ventePaiement.store') }}" method="post">
        @csrf
        <input type="hidden" name="commande_id" value="{{ $commande->id }}">

        <div class="row row-cols-2">
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">type du paiement <span class="text-danger">*</span></label>
              <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                <option value="">Choisir le type du paiement</option>
                <option value="espèce" {{ old('type') == 'espèce' || old('type') == null ? 'selected':'' }}>Espèce</option>
                <option value="chèque" {{ old('type') == 'chèque' ? 'selected':'' }}>Chèque</option>
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
              <label for="" class="form-label">Montant reste avance</label>
              <input type="number" id="reste" step="any" class="form-control" value="{{ $commande->reste ?? '' }}" disabled>
            </div>
          </div>
          <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">Montant payer <span class="text-danger">*</span></label>
              <input type="number" name="payer" id="payer" class="form-control @error('payer') is-invalid @enderror" step="any" min="0" value="{{ old('payer') }}"
                max="{{ $commande->reste }}"
                disabled>
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
              <label for="" class="form-label">Montant reste nouveau</label>
              <input type="number" name="" id="resteNew" step="any" class="form-control reste" value="" readonly>
            </div>
          </div>
        </div>



        <div class="d-flex justify-content-between">
          <a href="{{ route('ligneVente.index') }}" class="btn btn-retour waves-effect waves-light">
            <span>Retour</span>
          </a>
          <button type="submit" class="btn btn-action waves-effect waves-light">
            <span>Enregistrer</span>
          </button>
        </div>
      </form>
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
      $("#type").on("change", function() {
        var type = $(this).val();
        if (type == "chèque")
        {
          $("#cheque").show(450);
        } else {
          $("#cheque").hide(450);
        }
        if (type == "")
        {
          $("#payer").prop("disabled", true);
        }
        else
        {
          $("#payer").prop("disabled", false);
        }
      })
      $("#payer").on("keyup", function() {

        var payer = $(this).val();
        var reste = $("#reste").val();
        var reste_new = parseFloat(reste - payer).toFixed(2);
        $("#resteNew").val(reste_new);
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
