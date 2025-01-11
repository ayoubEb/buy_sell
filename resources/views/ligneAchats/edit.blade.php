@extends('layouts.master')
@section('content')
<div class="d-md-flex justify-content-between align-items-center">
  <h6 class="title-header">
    <a href="{{ route('ligneAchat.index') }}" class="btn btn-brown-outline px-4 py-1 waves-effect waves-light me-2">
      <span class="mdi mdi-arrow-left mdi-18px align-middle"></span>
    </a>
    Modification achat : {{ $ligneAchat->num_achat }}
  </h6>
  <div class="">
    @if ($count_pro != 0)
      @can('achat-nouveau')
        <a href="{{ route('achat.new',$ligneAchat) }}" class="btn btn-brown waves-effect waves-light ms-2">
          <i class="mdi mdi-plus-thick align-middle"></i>
        </a>
      @endcan
    @endif
    @can('ligneAchat-display')
      <a href="{{ route('ligneAchat.show',$ligneAchat) }}" class="btn btn-darkLight waves-effect waves-light">
        détails
      </a>
    @endcan
  </div>
</div>
@include('layouts.session')
  <div class="row">
    <div class="col-lg-7">
      <div class="card">
        <div class="card-body p-2">
          <h6 class="title mb-3">
            <span>
              basic information
            </span>
          </h6>
          <form action="{{ route('ligneAchat.update',$ligneAchat) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" id="ht" value="{{ $ligneAchat->ht }}">
            <div class="row row-cols-2">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Fournisseur</label>
                  <select name="fournisseur_id" class="form-select @error('fournisseur_id') is-invalid @enderror">
                    <option value="">Séléctionner le fournisseur</option>
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}" {{ $fournisseur->id == $ligneAchat->fournisseur_id ? "selected":"" }} @if($fournisseur->deleted_at != null ) class="text-danger" @endif>{{ $fournisseur->raison_sociale }}</option>
                    @endforeach
                  </select>
                  @error('fournisseur_id')
                    <strong class="invalid-feedback">
                      {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Date</label>
                  <input type="date" name="date_achat" id="" class="form-control @error('date_achat') is-invalid @enderror" value="{{ $ligneAchat->date_achat }}">
                  @error('date_achat')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                  @enderror
                </div>
              </div>

              <div class="col mb-2">
                <div class="form-group mb-2">
                  <label for="" class="form-label">Status</label>
                  <select name="statut" id="" class="form-select form-select @error('statut') is-invalid @enderror">
                    <option value="">Choisir le statut</option>
                    <option value="en cours" {{ $ligneAchat->statut == "en cours" ? "selected":"" }}>En cours</option>
                    <option value="validé" {{ $ligneAchat->statut == "validé" ? "selected":"" }}>Validé</option>
                    <option value="annulé" {{ $ligneAchat->statut == "annulé" ? "selected":"" }}>Annulé</option>
                  </select>
                  @error('statut')
                    <strong class="invalid-feedback">{{ $message }}</strong>
                  @enderror
                </div>
              </div>


              <div class="col mb-2">
                <div class="form-group mb-2">
                  <label for="" class="form-label">Taux tva</label>
                  <select name="tva" id="tva" class="form-select @error('tva') is-invalid @enderror">
                    <option value="">Choisir le status</option>
                    @foreach ($tvas as $tva)
                      <option value="{{ $tva }}" {{ $tva == $ligneAchat->taux_tva ? 'selected':'' }}> {{ $tva }}% </option>
                    @endforeach
                  </select>
                  @error('tva')
                  <strong class="invalid-feedback">
                    {{ $message }}
                  </strong>
                  @enderror
                </div>
              </div>

              @if (count($entreprises) > 1)
                <div class="col mb-2">
                  <div class="form-group">
                    <label for="" class="form-label">entreprise</label>
                    <select name="entreprise" class="form-select @error('entreprise') is-invalid @enderror">
                      <option value="">Choisir l'entreprise</option>
                      @forelse ($entreprises as $entreprise)
                        <option value="{{ $entreprise->id }}" {{ $ligneAchat->entreprise_id == $entreprise->id ? "selected" : "" }}> {{ $entreprise->raison_sociale }}</option>
                      @empty
                      @endforelse
                    </select>
                    @error('entreprise')
                      <strong class="invalid-feedback">
                        {{ $message }}
                      </strong>
                    @enderror
                  </div>
                </div>
              @endif

            </div>

            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-vert waves-effect waves-light">
                mettre à jour
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="col">
      <div class="card">
        <div class="card-body p-2">
          <h6 class="title mb-3">
            <span>
              paiements
            </span>
          </h6>
          <div class="table-responsive">
            <table class="table table-bordered m-0 info">
              <tbody id="info">
                <tr>
                  <td class="align-middle">ht</td>
                  <td class="align-middle fw-bolder">
                    <span id="ht">
                      {{ number_format($ligneAchat->ht , 2 , "," , " ") }} DHS
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">ttc</td>
                  <td class="align-middle fw-bolder">
                    <span id="ttc">
                      {{ number_format($ligneAchat->ttc , 2 , "," , " ") }} DHS
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">payer</td>
                  <td class="align-middle fw-bold">
                    <span class="text-success" id="payer">
                      {{ number_format($ligneAchat->payer , 2 , "," , " ") }} dhs
                    </span>
                  </td>
                </tr>
                <tr>
                  <td class="align-middle">reste</td>
                  <td class="align-middle fw-bold">
                    <span class="text-danger" id="reste">
                      {{ number_format($ligneAchat->reste , 2 , "," , " ") }} dhs
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body p-2">
      <div class="table-resposnive">
        <table class="table table-bordered table-customize m-0">
          <thead class="table-success">
            <tr>
              <th>Référence</th>
              <th>Désignation</th>
              <th>Quantite</th>
              <th>Prix achat</th>
              <th>Remise ( % )</th>
              <th>Montant</th>
              @canany(['achat-modification', 'achat-display', 'achat-suppression'])
              <th>opérations</th>
              @endcanany
            </tr>
          </thead>
          <tbody>
            @foreach ($ligneAchat->achats as $achat)
            <tr>
              <td class="align-middle">{{ $achat->produit->reference ?? '' }}</td>
              <td class="align-middle">{{ $achat->produit->designation ?? '' }}</td>
              <td class="align-middle">{{ $achat->quantite ?? '' }}</td>
              <td class="align-middle">{{ $achat->produit->prix_achat ?? 0 }} DH</td>
              <td class="align-middle">{{ $achat->remise ?? 0 }} %</td>
              <td class="align-middle">{{ $achat->montant ?? 0 }} DH</td>
              @canany(['achat-modification', 'achat-display', 'achat-suppression'])
                <td class="align-middle">
                  @can('achat-modification')
                    <a href="{{ route('achat.edit',$achat) }}" class="btn btn-primary waves-effect waves-light p-icon">
                      <span class="mdi mdi-pencil-outline align-middle"></span>
                    </a>
                  @endcan
                  @can('achat-display')

                  @endcan
                  @can('achat-suppression')
                    <button type="button" class="btn btn-danger waves-effect waves-light p-icon" data-bs-toggle="modal" data-bs-target="#delete{{ $achat->id}}">
                      <span class="mdi mdi-trash-can-outline align-middle"></span>
                    </button>
                    <div class="modal fade" id="delete{{ $achat->id}}" tabindex="-1" aria-labelledby="varyingModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                          <div class="modal-body">
                            <form action="{{ route('achat.destroy',$achat) }}" method="POST">
                              @csrf
                              @method("DELETE")
                              <h3 class="text-primary mb-3 text-center">Confirmer la suppression</h3>
                              <h6 class="mb-2 fw-bolder text-center text-muted">Voulez-vous supprimer défenitivement du produit</h6>
                              <h6 class="text-danger mb-2 text-center">{{ $achat->produit->reference }}</h6>
                              <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-vert waves-effect waves-light py-2 me-2">
                                  Je confirme
                                </button>
                                <button type="button" class="btn btn-orange waves-effect waves-light px-5 py-2 fw-bolder" data-bs-dismiss="modal" aria-label="btn-close">
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
  </div>
@endsection
