@extends('layouts.master')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-2">
  <h4 class="title-header">
    Liste des taux tvas
  </h4>
  <div class="">
    @can('tauxTva-nouveau')
    <a href="{{ route('tauxTva.create') }}" class="btn btn-brown px-4 waves-effect waves-light">
      <span class="mdi mdi-plus-thick"></span>
    </a>
    @endcan
    <a href="{{ route('tauxTva.exporter') }}" class="btn btn-brown px-4 waves-effect waves-light">
      exporter
    </a>
    <a href="{{ route('tauxTva.example') }}" class="btn btn-brown px-4 waves-effect waves-light">
      example
    </a>
    <a href="{{ route('tauxTva.document') }}" class="btn btn-brown px-4 waves-effect waves-light">
      document
    </a>
    <button type="button" class="btn btn-darkLight waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#import"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="suppression">
      importer
     </button>
     <div class="modal fade" id="import" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
       <div class="modal-dialog modal-md modal-dialog-centered">
         <div class="modal-content">
           <div class="modal-body p-3">
             <form action="{{ route('tauxTva.importer') }}" method="POST" enctype="multipart/form-data">
               @csrf
               <h6 class="title text-center mb-2">
                 importaiton fiche excel
               </h6>
               <div class="form-group mb-2">
                 <label for="" class="form-label">
                   fiche excel
                 </label>
                 <input type="file" name="file" class="form-control" id="">

               </div>
               <div class="row justify-content-center">
                 <div class="col-6">
                   <button type="submit" class="btn btn-vert waves-effect waves-light fw-bolder py-2 w-100">
                     Je confirme
                   </button>
                 </div>
                 <div class="col-6">
                   <button type="button" class="btn btn-orange px-5 waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                       Annuler
                   </button>
                 </div>
               </div>
             </form>
           </div>
         </div>
       </div>
     </div>

  </div>
</div>
<div class="card">
  <div class="card-body p-2">
    @include('layouts.session')
    <div class="table-responsive">
      <table class="table table-bordered table-customize m-0" >
        <thead class="table-primary">
          <tr>
            <th>nom</th>
            <th>valeur</th>
            <th>description</th>
            @canany(['tauxTva-modification', 'tauxTva-suppression','tauxTva-display'])
              <th>opérations</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($tauxTvas as $k =>  $tauxTva)
            <tr>
              <td class="align-middle">
                {!! $tauxTva->nom != '' ? $tauxTva->nom : '<i class="text-muted">N / A</i>' !!}
              </td>
              <td class="align-middle"> {{ $tauxTva->valeur ?? '' }}% </td>
              <td class="align-middle">
                {!! $tauxTva->description != '' ? $tauxTva->description : '<i class="text-muted">N / A</i>' !!}
              </td>
                @canany(['tauxTva-modification', 'tauxTva-suppression','tauxTva-display'])
                  <td class="align-middle">
                    @can('tauxTva-modification')
                      <a href="{{ route('tauxTva.edit',$tauxTva) }}" class="btn btn-primary p-icon waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modifier">
                        <span class="mdi mdi-pencil-outline align-middle"></span>
                      </a>
                    @endcan
                    @can('tauxTva-display')
                      <a href="{{ route('tauxTva.show',$tauxTva) }}" class="btn btn-dark p-icon waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modifier">
                        <span class="mdi mdi-eye-outline align-middle"></span>
                      </a>
                    @endcan
                    @can('tauxTva-suppression')
                      <button type="button" class="btn btn-danger p-icon waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="supprimer">
                        <span class="mdi mdi-trash-can align-middle"></span>
                      </button>
                      <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('tauxTva.destroy',$tauxTva) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>

                                <h6 class="mb-2 fw-bolder text-center text-muted">
                                    Voulez-vous vraiment suppression du tauxTva ?
                                </h6>
                                <h6 class="text-danger mb-2 text-center">{{ $tauxTva->valeur }}</h6>
                                  <div class="row">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-vert waves-effet waves-light w-100">
                                        <span class="mdi mdi-checkbox-marked-circle-outline"></span>
                                        Je confirme
                                      </button>
                                    </div>
                                    <div class="col-6">
                                      <button type="button" class="btn btn-orange waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                        <span class="mdi mdi-close"></span>
                                          Annuler
                                      </button>
                                    </div>
                                  </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endcan
                  </td>
                @endcanany
              </tr>
            @empty
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>





@endsection

{{-- @section('script')
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
@endsection --}}
