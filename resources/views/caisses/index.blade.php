@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">liste des catégories dépense</h4>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body p-2">
    <a href="{{ route('caisse.create') }}" class="btn btn-brown waves-effect waves-light mb-2">
      nouveau
    </a>
    @include('layouts.session')
    <div class="table-responsive">
      <table class="table table-bordered table-customize m-0">
        <thead>
          <tr>
            <th>categorie</th>
            <th>date</th>
            <th>montant</th>
            <th>description</th>
            <th>statut</th>
            @canany(['caisse-display', 'caisse-modification', 'caisse-suppression'])
            <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @foreach ($caisses as $k => $caisse)
            <tr>
              <td class="align-middle">
                {{ $caisse->categorie->nom }}
              </td>
              <td class="align-middle">
                {{ $caisse->datecaisse }}
              </td>
              <td class="align-middle">
                {{ number_format($caisse->montant , 2 , "," ," ") }} dh
              </td>
              <td class="align-middle">
                {{ $caisse->description }}
              </td>
              <td class="align-middle">
                @if ($caisse->statut == "en cours")
                <span class="text-primary">en cours</span>
                @elseif ($caisse->statut == "faire")
                <span class="text-success">faire</span>
                @elseif ($caisse->statut == "annuler")
                <span class="text-danger">annuler</span>
                @endif
              </td>
              @canany(['caisse-display', 'caisse-modification', 'caisse-suppression'])
              <td class="align-middle">
                @can('caisse-display')
                  <a href="{{ route('caisse.show',$caisse) }}" class="btn py-1 px-2 btn-warning waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="détail">
                    <span class="mdi mdi-eye-outline align-middle"></span>
                  </a>
                @endcan
                @can('caisse-modification')
                  <a href="{{ route('caisse.edit',$caisse) }}" class="btn py-1 px-2 btn-info waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modification">
                    <span class="mdi mdi-pencil-outline align-middle"></span>
                  </a>
                @endcan
                @can('caisse-suppression')
                  <button type="button" class="btn py-1 px-2 btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#destroy{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="suppression">
                    <span class="mdi mdi-trash-can"></span>
                  </button>
                  <div class="modal fade" id="destroy{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body">
                          <form action="{{ route('caisse.destroy',$caisse) }}" method="POST">
                            @csrf
                            @method("DELETE")
                            <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                            <h6 class="mb-2 fw-bolder text-center text-muted">
                                Voulez-vous vraiment suppression du dépense
                            </h6>
                            <h6 class="text-danger mb-2 text-center">{{ $caisse->nom }}</h6>
                            <div class="d-flex justify-content-center">
                              <button type="submit" class="btn btn-vert waves-effect waves-light fw-bolder py-2 me-2">
                                  Je confirme
                              </button>
                              <button type="button" class="btn btn-orange px-5 waves-effect waves-light" data-bs-dismiss="modal" aria-label="btn-close">
                                  Annuler
                              </button>
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
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection