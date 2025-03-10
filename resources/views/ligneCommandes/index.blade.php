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
      <table class="table table-bordered mb-0 table-sm">
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
            <th>Remise</th>
            <th>délai</th>
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
                <span class="fw-bold">
                  {{ number_format($commande->remise , 2 , ',' , ' ')." %" }}

                </span>
              </td>
              <td class="align-middle">
                {{ $commande->delai == 0 ? "aujourd'hui" : $commande->delai . ' jours' }}
              </td>
              <td class="align-middle">
                <span @class([
                  "mdi",
                  "mdi-progress-check mdi-18px text-warning"=>$commande->statut == "en cours",
                  "mdi-check-bold mdi-18px text-success"=>$commande->statut == "validé",
                  "mdi-close-thick mdi-18px text-danger"=>$commande->statut == "annuler",
                ])>
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
                              <div class="modal-body p-3">
                                <form action="{{ route('ligneVente.valider',$commande) }}" method="post">
                                  @csrf
                                  @method("PUT")
                                  <div class="d-flex justify-content-center">
                                    <span class="mdi mdi-check-circle-outline mdi-48px text-success"></span>
                                  </div>
                                  {{-- <h5 class="text-success mb-2 text-center">Valider la commande séléctionner ?</h5> --}}
                                  <h6 class="text-danger mb-2 text-center">{{ $commande->num ?? '' }}</h6>
                                  <h6 class="mb-3">Attention une fois validée , la commande ne peux pas plus modifiables !</h6>
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="submit" class="btn btn-vert waves-effect waves-light w-100">
                                        Validé
                                      </button>
                                    </div>
                                    <div class="col-6">
                                      <button type="button" class="btn btn-orange waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
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


                    @else
                      {{-- @if ($commande->etat_livraison == 0)
                        <a href="{{ route('venteLivraison.add',$commande->id) }}" class="btn btn-dark-outline waves-effect waves-light py-1 px-2">
                          <span class="mdi mdi-truck-outline"></span>
                        </a>
                      @else
                        <button type="button" class="btn btn-dark waves-effect waves-light py-1 px-2" data-bs-toggle="modal" data-bs-target="#livraison{{ $commande->id }}">
                          <span class="mdi mdi-truck-check-outline"></span>
                        </button>
                        <div class="modal fade" id="livraison{{ $commande->id }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-md modal-dialog-centered">
                            <div class="modal-content">
                              <div class="modal-body p-3">
                                <ul class="list-group">
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>numéro : </span>
                                      <span class="fw-normal">
                                        {{
                                          $commande->livraison &&
                                          $commande->livraison->num_livraison != '' ?
                                          $commande->livraison->num_livraison : ''
                                        }}
                                      </span>
                                    </h6>
                                  </li>
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>libelle : </span>
                                      <span class="fw-normal">
                                        {{
                                          $commande->livraison &&
                                          $commande->livraison->ville_livraison &&
                                          $commande->livraison->ville_livraison->libelle != '' ?
                                          $commande->livraison->ville_livraison->libelle : ''
                                        }}
                                      </span>
                                    </h6>
                                  </li>
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>ville : </span>
                                      <span class="fw-normal">
                                        {{
                                          $commande->livraison &&
                                          $commande->livraison->ville_livraison &&
                                          $commande->livraison->ville_livraison->ville != '' ?
                                          $commande->livraison->ville_livraison->ville : ''
                                        }}
                                      </span>
                                    </h6>
                                  </li>
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>prix : </span>
                                      <span class="fw-normal">
                                        {{
                                          $commande->livraison &&
                                          $commande->livraison->montant != '' ?
                                          number_format($commande->livraison->montant , 2 , "," ," ") . " DHS" : ''
                                        }}
                                      </span>
                                    </h6>
                                  </li>
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>adresse : </span>
                                      <span class="fw-normal">
                                        {{
                                          $commande->livraison &&
                                          $commande->livraison->adresse != '' ?
                                          $commande->livraison->adresse : ''
                                        }}
                                      </span>
                                    </h6>
                                  </li>
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>date depôt : </span>
                                      <span class="fw-normal">
                                        {{
                                          $commande->livraison &&
                                          $commande->livraison->date_depot != '' ?
                                          $commande->livraison->date_depot : ''
                                        }}
                                      </span>
                                    </h6>
                                  </li>
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>date livraison : </span>
                                      <span class="fw-normal">
                                        {{
                                          $commande->livraison &&
                                          $commande->livraison->date_livraison != '' ?
                                          $commande->livraison->date_livraison : ''
                                        }}
                                      </span>
                                    </h6>
                                  </li>
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>date réception : </span>
                                      <span class="fw-normal">
                                        {{
                                          $commande->livraison &&
                                          $commande->livraison->date_reception != '' ?
                                          $commande->livraison->date_reception : ''
                                        }}
                                      </span>
                                    </h6>
                                  </li>
                                  <li class="list-group-item">
                                    <h6 class="">
                                      <span>statut : </span>
                                      <span class="fw-normal">
                                        @if ($commande->livraison->date_livraison >= date("Y-m-d"))
                                          en cours
                                        @else
                                          en attente
                                        @endif
                                      </span>
                                    </h6>
                                  </li>
                                </ul>
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <button type="button" class="btn btn-orange waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
                                        Annuler
                                      </button>
                                    </div>
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      @endif --}}
                        <a href="{{ route('ventePaiement.add',$commande->id) }}" class="btn btn-success waves-effect waves-light py-1 px-2">
                          <span class="mdi mdi-plus-thick"></span>
                        </a>

                    @endif

                    <button type="button" class="btn btn-dark waves-effect waves-light py-1 px-2" data-bs-toggle="modal" data-bs-target="#files{{ $k }}">
                      <span class="mdi mdi-file-outline"></span>
                    </button>
                    <div class="modal fade" id="files{{ $k }}" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-centered">
                          <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title mt-0" id="myLargeModalLabel">Large
                                      modal</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                  </button>
                              </div>
                              <div class="modal-body">
                                <div class="row row-cols-2">
                                  @if ($commande->statut == "en cours")
                                    <div class="col">
                                      <a href="{{ route('ligneVente.devis',$commande->id) }}" class="btn btn-darkLight waves-effect waves-light w-100" target="_blank">
                                        devi
                                        <span class="mdi mdi-share-outline"></span>
                                      </a>
                                    </div>
                                    <div class="col">
                                      <a href="{{ route('ligneVente.facturePreforma',$commande->id) }}" class="btn btn-darkLight waves-effect waves-light w-100" target="_blank">
                                        facture préforma
                                        <span class="mdi mdi-share-outline"></span>
                                      </a>
                                    </div>
                                    @endif
                                    @if($commande->statut == "validé")
                                      <div class="col">
                                        <a href="{{ route('ligneVente.devis',$commande->id) }}" class="btn btn-darkLight waves-effect waves-light w-100 mb-2">
                                          devi
                                          <span class="mdi mdi-share-outline"></span>
                                        </a>
                                      </div>
                                      <div class="col">
                                        <a href="{{ route('ligneVente.facturePreforma',$commande->id) }}" class="btn btn-darkLight waves-effect waves-light w-100 mb-2">
                                          facture préforma
                                          <span class="mdi mdi-share-outline"></span>
                                        </a>
                                      </div>
                                      <div class="col">
                                        <a href="{{ route('ligneVente.facture',$commande->id) }}" class="btn btn-darkLight waves-effect waves-light w-100">
                                          facture
                                          <span class="mdi mdi-share-outline"></span>
                                        </a>
                                      </div>
                                  @endif
                                </div>
                              </div>
                          </div>
                          <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

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
{{-- <script>
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

</script> --}}
@endsection
