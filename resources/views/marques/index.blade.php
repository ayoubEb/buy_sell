@extends('layouts.master')
@section('title')
Liste des taux tvas
@endsection
@section('content')

<div class="card">
  <div class="card-body p-2">
    @can("marque-nouveau")
      <a href="{{ route('marque.create') }}" class="btn btn-lien waves-effect waves-light mb-2">
        <span>nouveau</span>
      </a>
    @endcan
    <div class="table-responsive">
      <table class="table table-bordered table-sm m-0 datatable" >
        <thead class="table-primary">
          <tr>
            <th>nom</th>
            <th>statut</th>
            @canany(['marque-modification', 'marque-suppression'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($marques as $k =>  $marque)
            <tr>
              <td class="align-middle"> {{ $marque->nom ?? '' }} </td>
              <td class="align-middle"> {{ $marque->statut ?? '' }} </td>
                @canany(['marque-modification', 'marque-suppression'])
                  <td class="align-middle">
                    @can('marque-modification')
                      <a href="{{ route('marque.edit',$marque->id) }}" class="btn btn-primary p-0 px-1 waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modifier">
                        <i class="mdi mdi-pencil-outline align-middle"></i>
                      </a>
                    @endcan
                    @can('marque-suppression')
                      <button type="button" class="btn btn-danger p-0 px-1 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="supprimer">
                        <span class="mdi mdi-trash-can"></span>
                      </button>
                      <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('marque.destroy',$marque->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>

                                <h6 class="mb-2 fw-bolder text-center text-muted">
                                    Voulez-vous vraiment déplacer du marque vers la corbeille
                                </h6>
                                <h6 class="text-danger mb-2 text-center">{{ $marque->nom }}</h6>
                                <div class="row row-cols-2">
                                  <div class="justify-content-evenly">
                                    <div class="col">
                                      <button type="submit" class="btn btn-vert waves-effet waves-light">
                                        <span class="mdi mdi-checkbox-marked-circle-outline"></span>
                                        Je confirme
                                      </button>
                                    </div>
                                    <div class="col">
                                      <button type="button" class="btn btn-orange waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                        <span class="mdi mdi-close"></span>
                                          Annuler
                                      </button>
                                    </div>
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
