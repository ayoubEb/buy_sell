@extends('layouts.master')

@section("content")
<div class="card">
  <div class="card-body p-2">
    @can('entreprise-nouveau')
      <a href="{{ route('entreprise.create') }}" class="btn btn-lien waves-effect waves-light">
        nouveau
      </a>
    @endcan
                <div class="table-responsive">
            <table class="table table-bordered m-0">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Raison Social</th>
                        <th>ICE</th>
                        <th>E-mail</th>
                        <th>Téléphone</th>
                        @canany(['entreprise-display', 'entreprise-modification', 'entreprise-suppression'])
                        <th>Actions</th>

                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse ($entreprises as $k => $entreprise)
                        <tr>
                            <td class="align-middle">
                                @if ($entreprise->logo != null)
                                    <img src="{{ asset('images/entreprise/'.$entreprise->logo) }}" alt="" class="avatar-md rounded-circle">
                                @else
                                    Aucun logo
                                @endif
                            </td>
                            <td class="align-middle">{{ $entreprise->raison_sociale }}</td>
                            <td class="align-middle">{{ $entreprise->ice }}</td>
                            <td class="align-middle">{{ $entreprise->email }}</td>
                            <td class="align-middle">{{ $entreprise->telephone }}</td>
                            @canany(['entreprise-display', 'entreprise-modification', 'entreprise-suppression'])

                            <td class="align-middle">
                                @can("entreprise-modification")
                                    <a href="{{ route('entreprise.edit',$entreprise) }}" class="btn btn-primary waves-effect waves-light py-1 px-2 rounded-circle">
                                        <i class="mdi mdi-pencil-outline align-middle"></i>
                                    </a>
                                @endcan
                                @can("entreprise-suppression")
                                    <button type="button" class="btn btn-danger waves-effect waves-light py-1 px-2 rounded-circle" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>
                                    <div class="modal fade" id="delete{{ $k }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header py-2">
                                                  <h6 class="modal-title m-0" id="exampleModalCenterTitle">Confirmer la suppression</h6>
                                                  <button type="button" class="btn bg-transparent p-0 border-0" data-bs-dismiss="modal" aria-label="Close">
                                                      <span class="mdi mdi-close-thick"></span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form action="{{ route('entreprise.destroy',$entreprise->id) }}" method="post">
                                                      @csrf
                                                      @method("DELETE")
                                                      <h6 class="mb-2 text-center text-muted">
                                                          Voulez-vous vraiment déplacer d'entreprise vers la corbeille
                                                      </h6>
                                                      <h6 class="mb-2 text-center fw-bolder fs-12 text-danger text-uppercase">
                                                          {{ $entreprise->raison_sociale ?? '' }}
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
                            @endcanany
                        </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="row">
            {{-- <div class="col-lg-4 col-6">
                <img src="{{ asset('images/logo.jpg') }}" alt="" class="img-fluid mt-2 mb-4">
                <ul class="list-group mt-3">
                    <li class="list-group-item py-2px d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fs-12 text-uppercase">raison sociale</h6>
                        <h6 class="m-0">&nbsp;:&nbsp;</h6>
                        <h6 class="m-0 fs-12 text-uppercase fw-normal">{{ $entreprise->raison_sociale ?? 'aucun'  }}</h6>
                    </li>
                    <li class="list-group-item py-2px d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fs-12 text-uppercase">ice</h6>
                        <h6 class="m-0">&nbsp;:&nbsp;</h6>
                        <h6 class="m-0 fs-12 text-uppercase fw-normal">{{ $entreprise->ice ?? 'aucun'  }}</h6>
                    </li>
                    <li class="list-group-item py-2px d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fs-12 text-uppercase">patente</h6>
                        <h6 class="m-0">&nbsp;:&nbsp;</h6>
                        <h6 class="m-0 fs-12 text-uppercase fw-normal">{{ $entreprise->patente ?? 'aucun'  }}</h6>
                    </li>
                </ul>
            </div> --}}
            <div class="col">
            </div>
        </div>

    </div>
</div>


@endsection
