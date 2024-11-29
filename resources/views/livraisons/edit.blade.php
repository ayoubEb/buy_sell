@extends('layouts.master')
@section('title')
taux tva : nouveau
@endsection
@section('content')



<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action="{{ route('livraison.update',$livraison) }}" method="post">
          @csrf
          @method("PUT")
          <div class="form-group mb-2">
            <label for="">prix</label>
            <input type="number" name="prix" id="" min="0" class="form-control @error('prix') is-invalid @enderror" value="{{ $livraison->prix }}">
            @error('prix')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>

          <div class="form-group mb-2">
            <label for="">libellé</label>
            <input type="text" name="libelle" id="" class="form-control @error('libelle') is-invalid @enderror" value="{{ $livraison->libelle }}">
            @error('libelle')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>
          <div class="form-group mb-2">
            <label for="" class="form-label">ville</label>
            <select name="ville" id="" class="form-select @error('ville') is-invalid @enderror">
              <option value="">--Veuillez choisir une ville--</option>
              <option value="Agadir" {{ $livraison->ville == 'Agadir' ? 'selected' : '' }} id="agadir">Agadir</option>
              <option value="Al Hoceima" {{ $livraison->ville == 'Al Hoceima' ? 'selected' : '' }} id="al-hoceima">Al Hoceima</option>
              <option value="Asilah" {{ $livraison->ville == 'Asilah' ? 'selected' : '' }} id="asilah">Asilah</option>
              <option value="Azrou" {{ $livraison->ville == 'Azrou' ? 'selected' : '' }} id="azrou">Azrou</option>
              <option value="Beni Mellal" {{ $livraison->ville == 'Beni Mellal' ? 'selected' : '' }} id="beni-mellal">Beni Mellal</option>
              <option value="Berkane" {{ $livraison->ville == 'Berkane' ? 'selected' : '' }} id="berkane">Berkane</option>
              <option value="Berrechid" {{ $livraison->ville == 'Berrechid' ? 'selected' : '' }} id="berrechid">Berrechid</option>
              <option value="Boujdour" {{ $livraison->ville == 'Boujdour' ? 'selected' : '' }} id="boujdour">Boujdour</option>
              <option value="Casablanca" {{ $livraison->ville == 'Casablanca' ? 'selected' : '' }} id="casablanca">Casablanca</option>
              <option value="Chefchaouen" {{ $livraison->ville == 'Chefchaouen' ? 'selected' : '' }} id="chefchaouen">Chefchaouen</option>
              <option value="El Jadida" {{ $livraison->ville == 'El Jadida' ? 'selected' : '' }} id="el-jadida">El Jadida</option>
              <option value="Errachidia" {{ $livraison->ville == 'Errachidia' ? 'selected' : '' }} id="errachidia">Errachidia</option>
              <option value="Essaouira" {{ $livraison->ville == 'Essaouira' ? 'selected' : '' }} id="essaouira">Essaouira</option>
              <option value="Fes" {{ $livraison->ville == 'Fes' ? 'selected' : '' }} id="fes">Fes</option>
              <option value="Fnideq" {{ $livraison->ville == 'Fnideq' ? 'selected' : '' }} id="fnideq">Fnideq</option>
              <option value="Guelmim" {{ $livraison->ville == 'Guelmim' ? 'selected' : '' }} id="guelmim">Guelmim</option>
              <option value="Ifrane" {{ $livraison->ville == 'Ifrane' ? 'selected' : '' }} id="ifran">Ifrane</option>
              <option value="Kenitra" {{ $livraison->ville == 'Kenitra' ? 'selected' : '' }} id="kenitra">Kenitra</option>
              <option value="Khemisset" {{ $livraison->ville == 'Khemisset' ? 'selected' : '' }} id="khemisset">Khemisset</option>
              <option value="Khouribga" {{ $livraison->ville == 'Khouribga' ? 'selected' : '' }} id="khouribga">Khouribga</option>
              <option value="Ksar El Kebir" {{ $livraison->ville == 'Ksar El Kebir' ? 'selected' : '' }} id="ksar-el-kebir">Ksar El Kebir</option>
              <option value="Laayoune" {{ $livraison->ville == 'Laayoune' ? 'selected' : '' }} id="laayoune">Laayoune</option>
              <option value="Larache" {{ $livraison->ville == 'Larache' ? 'selected' : '' }} id="larache">Larache</option>
              <option value="Marrakech" {{ $livraison->ville == 'Marrakech' ? 'selected' : '' }} id="marrakech">Marrakech</option>
              <option value="Meknes" {{ $livraison->ville == 'Meknes' ? 'selected' : '' }} id="meknes">Meknes</option>
              <option value="Mohammedia" {{ $livraison->ville == 'Mohammedia' ? 'selected' : '' }} id="mohammedia">Mohammedia</option>
              <option value="Nador" {{ $livraison->ville == 'Nador' ? 'selected' : '' }} id="nador">Nador</option>
              <option value="Ouarzazate" {{ $livraison->ville == 'Ouarzazate' ? 'selected' : '' }} id="ouarzazate">Ouarzazate</option>
              <option value="Oujda" {{ $livraison->ville == 'Oujda' ? 'selected' : '' }} id="oujda">Oujda</option>
              <option value="Rabat" {{ $livraison->ville == 'Rabat' ? 'selected' : '' }} id="rabat">Rabat</option>
              <option value="Safi" {{ $livraison->ville == 'Safi' ? 'selected' : '' }} id="safi">Safi</option>
              <option value="Sidi Kacem" {{ $livraison->ville == 'Sidi Kacem' ? 'selected' : '' }} id="sidi-kacem">Sidi Kacem</option>
              <option value="Sidi Slimane" {{ $livraison->ville == '' ? 'selected' : '' }} id="sidi-slimane">Sidi Slimane</option>
              <option value="Settat" {{ $livraison->ville == 'Sidi Slimane' ? 'selected' : '' }} id="settat">Settat</option>
              <option value="Skhirat" {{ $livraison->ville == 'Skhirat' ? 'selected' : '' }} id="skhirat">Skhirat</option>
              <option value="Tan-Tan" {{ $livraison->ville == 'Tan-Tan' ? 'selected' : '' }} id="tan-tan">Tan-Tan</option>
              <option value="Tangier" {{ $livraison->ville == 'Tangier' ? 'selected' : '' }} id="tangier">Tangier</option>
              <option value="Taourirt" {{ $livraison->ville == 'Taourirt' ? 'selected' : '' }} id="taourirt">Taourirt</option>
              <option value="Taroudant" {{ $livraison->ville == 'Taroudant' ? 'selected' : '' }} id="taroudant">Taroudant</option>
              <option value="Taza" {{ $livraison->ville == 'Taza' ? 'selected' : '' }} id="taza">Taza</option>
              <option value="Temara" {{ $livraison->ville == 'Temara' ? 'selected' : '' }} id="temara">Temara</option>
              <option value="Tetouan" {{ $livraison->ville == 'Tetouan' ? 'selected' : '' }} id="tetouan">Tetouan</option>
              <option value="Boumerdès" {{ $livraison->ville == 'Boumerdès' ? 'selected' : '' }} id="boumerdes">Boumerdès</option>
              <option value="Moulay Bousselham" {{ $livraison->ville == 'Moulay Bousselham' ? 'selected' : '' }} id="moulay-bousselham">Moulay Bousselham</option>
              <option value="Tiznit" {{ $livraison->ville == 'Tiznit' ? 'selected' : '' }} id="tiznit">Tiznit</option>
              <option value="Tinghir" {{ $livraison->ville == 'Tinghir' ? 'selected' : '' }} id="tinghir">Tinghir</option>
              <option value="Inezgane" {{ $livraison->ville == 'Inezgane' ? 'selected' : '' }} id="inezgane">Inezgane</option>
              <option value="Tarfaya" {{ $livraison->ville == 'Tarfaya' ? 'selected' : '' }} id="tarfaya">Tarfaya</option>
            </select>
            @error('ville')
            <strong class="invalid-feedback">
              {{ $message }}
            </strong>
          @enderror
          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ url()->previous() }}" class="btn btn-retour waves-effect waves-light">
              <span>Retour</span>
            </a>
            <button type="submit" class="btn btn-action waves-effect waves-light">
              <span>Enregistrer</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



@endsection