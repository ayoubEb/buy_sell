@extends('layouts.master')
@section('title')
  new stock
@endsection
@section('content')
<h4 class="title-header">
  <a href="{{ route('stock.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
    <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
  </a>
  nouveau stock
</h4>
<div class="row justify-content-center">
  <div class="col-xxl-9">
    <div class="card">
      <div class="card-body p-2">
        <form action="{{ route('stock.store') }}" method="post">
          @csrf
          <div class="row row-cols-2">
            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">référence</label>
                <input type="text" name="reference_pro" id="" class="form-control" readonly value="{{ $produit->reference }}">
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Min <span class="text-danger">*</span></label>
                <input type="number" name="qte_min" id="" class="form-control @error('qte_min') is-invalid @enderror" min="1" value="{{ old('qte_min') != 1 ? 1 : old('qte_min') }}">
                @error('qte_min')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">Max</label>
                <input type="number" name="qte_max" id="" class="form-control @error('qte_max') is-invalid @enderror" min="1" value="{{ old('qte_max') != 1 ? 1 : old('qte_max') }}">
                @error('qte_max')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

            <div class="col mb-2">
              <div class="form-group">
                <label for="" class="form-label">alert</label>
                <input type="number" name="qte_alert" id="" class="form-control @error('qte_alert') is-invalid @enderror" min="1" value="{{ old('qte_alert') != 1 ? 1 : old('qte_alert') }}">
                @error('qte_alert')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                @enderror
              </div>
            </div>

          </div>

          <article class="" id="list-depots">
            <div class="d-flex justify-content-center loading">
              <span></span>
            </div>
            <h5 class="title">
              depôts
            </h5>
            <div class="table-reponsive">
              <table class="table table-bordered table-customize m-0">
                <thead>
                  <tr>
                    <th>num</th>
                    <th>adresse</th>
                    <th>quantite</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($depots as $k => $depot)
                    <tr>
                      <td class="align-middle">
                        <input type="hidden" class="dep-num" value="{{ $depot->num_depot }}">
                        <div class="form-check" style="cursor: pointer;">
                          <input type="checkbox" name="depot[]" id="dep{{$depot->id}}" class="form-check-input dep" value="{{ $depot->id }}">
                          <label for="dep{{$depot->id}}" class="form-check-label"> {{ $depot->num_depot }} </label>
                        </div>
                      </td>
                      <td class="align-middle">
                        {{ $depot->adresse }}
                      </td>
                      <td class="align-middle">
                        <input type="number" name="qte[]" id="" min="0" class="form-control form-control-sm" value="{{old('qte['. $k .']') }}" disabled>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>

          </article>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-vert waves-effect waves-light">
              enregistrer
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
  <script>
    $(document).ready(function () {
      setTimeout(function() {
          $('#list-depots').fadeIn();
          $(".loading").remove();
      }, 50);

;


      $(".dep").on("change",function(e){
        var dep = $(e.target).parent().parent().parent();
        var dep_event = $(e.target);
        var num_dep =  dep_event.parent().parent().children(".dep-num").val();
        var dep_default = $("#depDefault");
        if(dep_event.is(":checked")){
          dep.addClass("table-success");
          dep.children("td").children("input").prop("disabled",false);
          dep.children("td").children("input").prop("required",true);
          dep.children("td:nth-child(3)").children("input").val(0);
          $("#depDefault").append('<option value="' + num_dep + '">' + num_dep + ' </option>')
        }
        else
        {
          dep.removeClass("table-success");
          dep.children("td").children("input").prop("disabled",true);
          dep.children("td").children("input").prop("required",false);
          dep.children("td:nth-child(3)").children("input").val('');
          dep.children("td").children("input").prop("disabled",true);
          $('#depDefault option[value="' + num_dep + '"]').remove();
        }




      })
    });
  </script>
@endsection