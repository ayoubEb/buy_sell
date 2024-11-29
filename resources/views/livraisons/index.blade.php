@extends('layouts.master')
@section('title')
Liste des taux tvas
@endsection
@section('content')

<div class="card">
  <div class="card-body p-2">
    @can("tauxTva-nouveau")
      <a href="{{ route('livraison.create') }}" class="btn btn-lien waves-effect waves-light mb-2">
        <span>nouveau</span>
      </a>
    @endcan
    <div class="table-responsive">
      <table class="table table-bordered table-sm m-0 datatable" >
        <thead class="table-primary">
          <tr>
            <th>ville</th>
            <th>prix</th>
            <th>periode</th>
            <th>mois / jours</th>
            @canany(['livraison-modification','livraison-display', 'livraison-suppression'])
              <th>actions</th>
            @endcanany
          </tr>
        </thead>
        <tbody>
          @forelse ($livraisons as $k =>  $livraison)
            <tr>
              <td class="align-middle"> {{ $livraison->ville ?? '' }} </td>
              <td class="align-middle"> {{ $livraison->prix ?? '' }}% </td>
              <td class="align-middle"> {{ $livraison->period ?? '' }} </td>
              <td class="align-middle"> {{ $livraison->periodAffecter ?? '' }} </td>
              @canany(['livraison-modification','livraison-display', 'livraison-suppression'])
                  <td class="align-middle">
                    @can('livraison-display')
                      <a href="{{ route('livraison.show',$livraison->id) }}" class="btn btn-info p-0 px-1 waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modifier">
                        <i class="mdi mdi-eye-outline"></i>
                      </a>
                    @endcan
                    @can('livraison-modification')
                      <a href="{{ route('livraison.edit',$livraison->id) }}" class="btn btn-primary p-0 px-1 waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="bottom" title="modifier">
                        <i class="mdi mdi-pencil-outline"></i>
                      </a>
                    @endcan
                    @can('livraison-suppression')
                      <button type="button" class="btn btn-danger p-0 px-1 waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#delete{{ $k }}"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="supprimer">
                        <span class="mdi mdi-trash-can"></span>
                      </button>
                      <div class="modal fade" id="delete{{ $k }}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-md modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-body">
                              <form action="{{ route('livraison.destroy',$livraison->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>

                                <h6 class="mb-2 fw-bolder text-center text-muted">
                                    Voulez-vous vraiment déplacer du tauxTva vers la corbeille
                                </h6>
                                <h6 class="text-danger mb-2 text-center">{{ $livraison->prix }}</h6>
                                <div class="row row-cols-2">
                                  <div class="justify-content-evenly">
                                    <div class="col">
                                      <button type="submit" class="btn btn-action waves-effet waves-light">
                                        <span class="mdi mdi-checkbox-marked-circle-outline"></span>
                                        Je confirme
                                      </button>
                                    </div>
                                    <div class="col">
                                      <button type="button" class="btn btn-fermer waves-effect waves-light w-100" data-bs-dismiss="modal" aria-label="btn-close">
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
