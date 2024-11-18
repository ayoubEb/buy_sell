@extends('layouts.master')
@section('title')
taux tva : nouveau
@endsection
@section('content')



<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action="{{ route('tauxTva.store') }}" method="post">
          @csrf
          <div class="form-group mb-2">
            <label for="">nom</label>
            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
            @error('nom')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="">Valeur</label>
            <input type="number" name="valeur" id="" min="0" step="any" class="form-control @error('valeur') is-invalid @enderror" value="{{ old('valeur') }}">
            @error('valeur')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="">description</label>
            <textarea name="description" id="" rows="10" class="form-control"> {{old("description")}}</textarea>
          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-retour waves-effect waves-light">
              <span>Retour</span>
            </a>
            <button type="submit" class="btn btn-vert waves-effect waves-light">
              <span>Enregistrer</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




{{-- <div class="modal fade" id="add" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary py-2">
                <h6 class="modal-title m-0 text-white" id="varyingModalLabel">Ajouter des caractéristiques</h6>
                <button type="button" class="btn btn-transparent p-0 text-white border-0" data-bs-dismiss="modal" aria-label="btn-close">
                    <span class="mdi mdi-close-thick"></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('caracteristique.store') }}" method="post">
                    @csrf
                    <div class="row row-cols-2" id="autre">
                        <div class="col">
                            <div class="card poisition-relative">
                                <div class="card-body p-2">
                                    <div class="form-group mb-2">
                                        <label for="">Nom</label>
                                        <input type="text" name="nom[]" id="" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-sm btn-dark" id="nouveau">Ajouter autre caractéristique</button>

                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="mdi mdi-checkbox-marked-circle-outline align-middle"></i>
                            <span>Enregistrer</span>
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}
@endsection

@section('script')
<script>

$(document).ready(function(){
  $('#nouveau').on('click',function(){
    var html="";
    html+='<div class="col">';
        html+='<div class="card poisition-relative">';
            html+='<button type="button" class="position-absolute top-0 btn btn-outline-danger btn-sm rounded-circle" id="remove"style="left:92%"><span class="mdi mdi-close-thick fw-bolder"></span></button>';
            html+='<div class="card-body p-2">';
                html += '<div class="form-group mb-2">';
                    html+='<label for="">Nom</label>';
                    html+='<input type="text" name="nom[]" id="" class="form-control" required>';
                html += '</div>';
            html += '</div>';
        html += '</div>';
    html += '</div>';
    $('#autre').append(html);
  });

});

$(document).on('click','#remove',function() {
    $(this).closest('.col').remove();
})

</script>
@endsection
