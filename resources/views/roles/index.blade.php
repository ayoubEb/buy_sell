@extends('layouts.master')
@section('title')
    Liste des autorisation
@endsection
@section('content')

<div class="card">
  <div class="card-body p-2">
    @include('layouts.session')
    @can("role-nouveau")
      <a href="{{ route('role.create') }}" class="btn btn-primary btn-sm">
        <span class="mdi mdi-plus-circle-outline align-middle"></span>
        Nouveau
      </a>
    @endcan
    <div class="table-responsive">
      <table class="table table-bordered table-sm m-0 datatable">
        <thead>
          <tr>
            <th>Name</th>
            @canany(['role-modification', 'role-suppression', 'role-display'])
              <th>Actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @foreach ($roles as $key => $role)
            <tr>
              <td class="align-middle">{{ $role->name }}</td>
              @canany(['role-modification', 'role-suppression', 'role-display'])
              <td class="align-middle">
                @can('role-display')
                <a class="btn text-primary bg-transaprent p-0" href="{{ route('role.show',$role->id) }}">
                  <i class="mdi mdi-eye-outline align-middle" style="font-size: 0.90rem"></i>
                </a>
                @endcan
                @if (!$loop->first)
                  @can('role-modification')
                    <a class="btn btn-primary waves-effect waves-light py-1 px-2 rounded-circle" href="{{ route('role.edit',$role->id) }}">
                      <i class="mdi mdi-pencil-outline align-middle"></i>
                    </a>
                  @endcan
                    @can('role-suppression')
                      <button type="button" class="btn text-primary bg-transaprent p-0" data-bs-toggle="modal" data-bs-target="#delete{{ $role->id }}">
                        <i class="mdi mdi-trash-can"></i>
                      </button>
                  @endcan
                  @else
                  N/A
                  @endif
              </td>
              @endcanany
            </tr>
          @endforeach
        </tbody>

      </table>
    </div>
  </div>
</div>

@foreach ($roles as $key => $role)

    <div class="modal fade" id="delete{{ $role->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    {!! Form::open(['method' => 'DELETE','route' => ['role.destroy', $role->id],'style'=>'display:inline']) !!}
                    <div class="p-3 mb-3">
                        <h5 class="mb-2 fw-bolder text-center">Voulez-vous supprimer défenitivement du role</h5>
                        <h6 class="text-danger text-center fw-bolder w-100">{{ $role->name }}</h6>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-success p-3 w-100" style="border-radius:0;border-bottom-left-radius: 0.375rem;" data-bs-dismiss="modal" aria-label="btn-close">
                            Fermer
                        </button>
                        <button type="submit" class="btn btn-danger p-3 w-100 fw-bolder fs-6" style="border-radius:0;border-bottom-right-radius: 0.375rem;" >
                            Supprimer
                        </button>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection
