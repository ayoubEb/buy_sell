@extends('layouts.master')
@section('title')
Liste des commandes
@endsection
@section('content')


<div class="card">
  <div class="card-body p-2">
    @can('ligneVente-nouveau')
      <a href="{{ route('ligneVente.create') }}" class="btn btn-brown waves-effect waves-light mb-2">
        nouveau
      </a>
    @endcan
    <div class="table-responsive">
      <table class="table table-bordered mb-0 table-sm" id="dt">
        <thead class="table-success">
          <tr>
            <th>#ID</th>
            <th>Numero du commande</th>
            <th>Raison sociale</th>
            <th>Date du commande</th>
            <th>Prix HT</th>
            <th>Prix TTC</th>
            <th>net à payer</th>
            <th>payer</th>
            <th>reste</th>
            <th>Taux TVA</th>
            <th>Remise</th>
            <th>Statut</th>
            @canany(['ligneVente-modification', 'ligneVente-display', 'ligneVente-suppression'])
              <th>Actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($commandes as $k => $commande)
            <tr>
              <td class="align-middle">
                  {{"#" . $commande->id ?? '' }}
              </td>
              <td class="align-middle">
                  {{ $commande->num ?? '' }}
              </td>
              <td class="align-middle">
                {!!
                  $commande->client &&
                  $commande->client->deleted_at == '' ?
                  $commande->client->raison_sociale : '<span class="text-danger"> '. $commande->client->raison_sociale . '</span>'
                !!}
              </td>
              <td class="align-middle">
                {{ date('d-m-Y',strtotime($commande->created_at)) ?? '' }}
              </td>
              <td class="align-middle">
                <span class="fw-bold mt">
                  {{ number_format($commande->ht , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold mt">
                  {{ number_format($commande->ttc , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-primary mt">
                  {{ number_format($commande->net_payer , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-success mt">
                  {{ number_format($commande->payer , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>
              <td class="align-middle">
                <span class="fw-bold text-danger mt">
                  {{ number_format($commande->reste , 2 , ',' , ' ')." DHS" }}
                </span>
              </td>
              <td class="align-middle">
                {{ $commande->taux_tva ?? '0' }} %
              </td>
              <td class="align-middle">
                {{ $commande->remise }} %
              </td>
              <td class="align-middle">
                <span @class([
                  "badge",
                  "bg-warning"=>$commande->statut == "en cours",
                  "bg-success"=>$commande->statut == "validé",
                  "bg-danger"=>$commande->statut == "annuler",
                ])>
                  {{ $commande->statut }}
                </span>
              </td>
              @canany(['ligneVente-display','ligneVente-modification','ligneAvoire-nouveau'])
                <td class="align-middle">
                  @can('ligneVente-display')

                    <a href="{{ route('ligneVente.show',$commande->id) }}" class="{{ $commande->status == "validé" ? 'd-none':'' }} btn btn-warning waves-effect waves-light py-1 px-2">
                        <span class="mdi mdi-eye-outline"></span>
                    </a>

                  @endcan

                  @if ($commande->client->deleted_at == null)
                    @if ($commande->statut != "validé")
                      @can('ligneVente-modification')
                        <a href="{{ route('ligneVente.edit',$commande->id) }}" class="{{ $commande->status == "validé" ? 'd-none':'' }} btn btn-primary waves-effect waves-light py-1 px-2">
                            <span class="mdi mdi-pencil"></span>
                        </a>
                        <button type="button" class="btn btn-success waves-effect waves-light py-1 px-2" data-bs-toggle="modal" data-bs-target="#validation{{ $commande->id }}">
                          <span class="mdi mdi-check-bold"></span>
                        </button>
                        <div class="modal fade" id="validation{{ $commande->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body p-4">
                                <form action="{{ route('ligneVente.valider',$commande) }}" method="post">
                                  @csrf
                                  @method("PUT")
                                  <h5 class="text-primary mb-2 text-center">Valider la commande séléctionner ?</h5>
                                  <h6 class="text-danger mb-2 text-center">{{ $commande->num ?? '' }}</h6>
                                  <h6 class="mb-3">Attention une fois validée , la commande ne peux pas plus modifiables !</h6>
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
                      @endcan
                    @else
                        <a href="{{ route('ventePaiement.add',$commande->id) }}" class="btn btn-success waves-effect waves-light py-1 px-2">
                          <span class="mdi mdi-plus-thick"></span>
                        </a>
                    @endif

                  @else
                    <button type="button" class="btn btn-danger p-0 px-1 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#warn{{ $k }}">
                    <i class="mdi mdi-alert-outline"></i>
                  </button>
                  <div class="modal fade" id="warn{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                      <div class="modal-content">
                        <div class="modal-body">
                          <div class="text-center text-danger">
                            <span class="mdi mdi-alert-outline mdi-48px"></span>
                          </div>

                          <h6 class="text-center text-primary">
                            Le client : {{ $commande->client->raison_sociale }} a été suppression
                          </h6>
                          <p class="text-center fw-bold">
                            Il ne peux pas faire des modification pour {{ $commande->status == "en cours" ? "devis" : "commande" }} .
                          </p>
                          <div class="row justify-content-center mt-4">

                            <div class="col-lg-5">
                              <button type="button" class="btn btn-fermer waves-effect waves-light py-3 w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                Annuler
                              </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endif
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
