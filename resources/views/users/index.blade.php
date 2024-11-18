@extends('layouts.master')
@section('title')
    Liste des utilisateurs
@endsection
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">liste des utilisateurs</h4>
    </div>
  </div>
</div>

@include('layouts.session')
<div class="card">
  <div class="card-body p-2">
    @can("user-nouveau")
        <a href="{{ route('user.create') }}" class="btn btn-brown waves-effect waves-light mb-2" >
              <span>
                Ajouter
              </span>
        </a>
    @endcan

    <div class="table-responsive">
      <table class="table table-striped mb-0 datatable table-sm" >
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            @canany(['user-modification', 'user-display', 'user-suppression'])
              <th>opérations</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $user)
            <tr>
              <td class="align-middle">{{ $user->name ?? '' }}</td>
              <td class="align-middle">{{ $user->email ?? '' }}</td>
              <td class="align-middle">
                  @can('user-modification')
                      <a href="{{ route('user.edit',$user->id) }}" class="btn btn-primary waves-effect waves-light py-1 px-2 rounded-circle" >
                          <i class="mdi mdi-pencil-outline align-middle"></i>
                      </a>
                  @endcan

                      @can('user-suppression')
                          <button type="button" class="btn bg-transparent border-0 text-primary p-0" data-bs-toggle="modal" data-bs-target="#delete{{ $user->id }}">
                              <i class="mdi mdi-trash-can"></i>
                          </button>


    <div class="modal fade" id="delete{{ $user->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-md modal-dialog-centered">
          <div class="modal-content">
              <div class="modal-body">
                  <form action="{{ route('user.destroy',$user->id) }}" method="POST">
                      @csrf
                      @method("DELETE")
                      <h6 class="mb-2 text-center text-muted">
                          Voulez-vous vraiment déplacer d'utilisateur vers la corbeille
                      </h6>
                      <h6 class="mb-2 text-center text-danger text-uppercase fw-bolder fs-12">
                          {{ $user->name }}
                      </h6>
                      <div class="row justify-content-center">
                          <div class="col-lg-5">
                              <button type="submit" class="btn btn-success btn-sm w-100">OUI</button>
                          </div>
                          <div class="col-lg-5">
                              <button type="button" class="btn btn-danger btn-sm w-100" data-bs-dismiss="modal" aria-label="Close">
                                  NON
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
              </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection

@section('script')
    <script>
        $(".toggle-password").click(function() {
    $(this).toggleClass("mdi mdi-eye-outline align-middle mdi mdi-eye-off-outline");
    input = $(this).parent().parent().find("input");
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
    });
    </script>
@endsection
