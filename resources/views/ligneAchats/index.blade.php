@extends('layouts.master')
@section('title')
  Liste des achats
@endsection
@section('content')
@can('ligneAchat-nouveau')
  <a href="{{ route('ligneAchat.create') }}" class="btn btn-brown waves-effect waves-light mb-2">
    <span>Nouveau</span>
  </a>
@endcan
<div class="card">
  <div class="card-body p-2">
    @include('layouts.session')
    <div class="table-responsive">
      <table class="table table-bordered table-customize m-0">
        <thead>
          <tr>
            <th>numero</th>
            <th>fournisseur</th>
            <th>date</th>
            <th>nombre.pro</th>
            <th>montant ht</th>
            <th>montant ttc</th>
            <th>payer</th>
            <th>reste</th>
            <th>status</th>
            @canany(['ligneAchat-modification','ligneAchat-display'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($ligneAchats as $k => $ligne)
            <tr>
              <td class="align-middle"> {{ $ligne->num_achat ?? '' }} </td>
              <td class="align-middle">
                {!!
                  $ligne->fournisseur->deleted_at == null ?
                  $ligne->fournisseur->raison_sociale : '<i class="text-muted">' . $ligne->fournisseur->raison_sociale . '</i>'
                !!}
              </td>
              <td class="align-middle"> {{ $ligne->date_achat ?? '' }} </td>
              <td class="align-middle"> {{ $ligne->nombre_achats ?? '' }} </td>
              <td class="align-middle text-uppercase fw-bold">
                {{ number_format($ligne->ht , 2 , ',' , ' ') }} dh
              </td>
              <td class="align-middle text-uppercase fw-bold "> {{ number_format($ligne->ttc , 2 , ',' , ' ') }} dh </td>
              <td class="align-middle text-uppercase text-success fw-bold"> {{ number_format($ligne->payer , 2 , ',' , ' ') }} dh </td>
              <td class="align-middle text-uppercase text-danger fw-bold"> {{ number_format($ligne->reste , 2 , ',' , ' ') }} dh </td>
              <td class="align-middle">
                @if ($ligne->status == "validé")
                <span class="badge bg-success">
                  <span class="mdi mdi-check"></span>
                  {{ $ligne->status }}
                </span>
                @elseif ($ligne->status == "en cours")
                  <span class="badge bg-warning">
                    <span class="mdi mdi-cog-clockwise align-middle"></span>
                    {{ $ligne->status }}
                  </span>
                @else
                  <span class="mdi mdi-cancel text-danger"></span>
                @endif
              </td>
              @canany(['ligneAchat-modification','ligneAchat-display'])
                <td class="align-middle">
                  @if ($ligne->fournisseur->deleted_at == null)
                    @if ($ligne->statut == "en cours")
                      @can('ligneAchat-modification')
                        <button type="button" class="btn btn-success py-1 px-2 shadow-none" data-bs-toggle="modal" data-bs-target="#valider{{ $ligne->id }}">
                            <span class="mdi mdi-check-bold "></span>
                        </button>
                        <div class="modal fade" id="valider{{ $ligne->id }}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
                            <div class="modal-content">

                              <div class="modal-body">
                                <form action="{{ route('ligneAchat.valider',$ligne) }}" method="post">
                                  @csrf
                                  @method("PUT")
                                  <span class="mdi mdi-check-bold text-success mdi-24px"></span>
                                <h5 class="text-primary mb-2 text-center">Valider la facture séléctionner ?</h5>
                                <h6 class="text-danger mb-2 text-center">{{ $ligne->num_achat ?? '' }}</h6>
                                <h6 class="mb-3">Attention une fois validée , l'achat ne peux pas plus modifiables !</h6>
                                <div class="d-flex justify-content-center">
                                  <button type="submit" class="btn btn-vert waves-effect waves-light px-5 me-2">
                                    Validé
                                  </button>
                                  <button type="button" class="btn btn-orange waves-effect waves-light px-5" data-bs-dismiss="modal" aria-label="btn-close">
                                    Annuler
                                  </button>
                                </div>

                                </form>

                              </div>
                            </div>
                          </div>
                        </div>

                        <a href="{{ route('ligneAchat.edit',$ligne) }}" class="btn btn-primary py-1 px-2 shadow-none">
                            <span class="mdi mdi-pencil-outline align-middle"></span>
                        </a>

                      @endcan

                      @can('ligneAchat-display')
                        <a href="{{ route('ligneAchat.demandePrice',$ligne) }}" class="btn btn-dark waves-effect waves-light py-1 px-2" target="_blank">
                          <span class="mdi mdi-file-outline"></span>
                        </a>
                      @endcan
                    @else
                      @can('ligneAchat-display')
                        <a href="{{ route('ligneAchat.bon',$ligne) }}" class="btn btn-dark waves-effect waves-light py-1 px-2" target="_blank">
                          <span class="mdi mdi-file-outline"></span>
                        </a>
                      @endcan
                      @can('achatPaiement-nouveau')
                        <a href="{{ route('achatPaiement.new',$ligne) }}" class="btn btn-success waves-effect waves-light py-1 px-2">
                          <span class="mdi mdi-plus-thick align-middle"></span>
                        </a>
                      @endcan
                    @endif
                  @else
                    <button type="button" class="btn btn-danger py-1 px-2 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#warn{{ $k }}">
                      <i class="mdi mdi-alert-outline"></i>
                    </button>
                    <div class="modal fade" id="warn{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <div class="text-center text-danger">
                              <span class="mdi mdi-alert-outline mdi-48px"></span>
                            </div>
                            <h5 class="text-center">
                              Le fournisseur <span class="text-danger"> {{ $ligne->fournisseur->raison_sociale }} </span> a été supprimer
                            </h5>

                            <div class="row justify-content-center mt-4">

                              <div class="col-lg-5">
                                <button type="button" class="btn btn-orange waves-effect waves-light py-3 w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                  fermer
                                </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                  @can('ligneAchat-display')
                    <a href="{{ route('ligneAchat.show',$ligne) }}" class="btn btn-warning py-1 px-2 waves-effect waves-light">
                      <span class="mdi mdi-eye-outline align-middle "></span>
                    </a>
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



@section('script')
<script>
 $(document).ready(function() {
    $('#dt').DataTable({
        "columnDefs": [
            {
                "targets": 0, // Assuming the ID column is the first column (index 0)
                "type": "num" // Forces numeric sorting
            }
        ]
    });
});

</script>
@endsection
