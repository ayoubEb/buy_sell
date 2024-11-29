
@extends('layouts.master')
@section('title')
taux tva : nouveau
@endsection
@section('content')



<div class="card">
  <div class="card-body p-2">
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <form action="{{ route('livraison.store') }}" method="post">
          @csrf

          <div class="form-group mb-2">
            <label for="">prix</label>
            <input type="number" name="prix" id="" min="0" class="form-control @error('prix') is-invalid @enderror" value="{{ old('prix') }}">
            @error('prix')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>

          <div class="form-group mb-2">
            <label for="">libellé</label>
            <input type="text" name="libelle" id="" class="form-control @error('libelle') is-invalid @enderror" value="{{ old('libelle') }}">
            @error('libelle')
              <strong class="invalid-feedback">
                {{ $message }}
              </strong>
            @enderror
          </div>




          <div class="form-group mb-2">
            <label for="" class="form-label">ville</label>
            <select name="ville" id="" class="form-select @error('ville') is-invalid @enderror">
              <option value="" selected>--Veuillez choisir une ville--</option>
              <option value="Agadir" {{ old('ville') == 'Agadir' ? 'selected' : '' }} id="agadir">Agadir</option>
              <option value="Al Hoceima" {{ old('ville') == 'Al Hoceima' ? 'selected' : '' }} id="al-hoceima">Al Hoceima</option>
              <option value="Asilah" {{ old('ville') == 'Asilah' ? 'selected' : '' }} id="asilah">Asilah</option>
              <option value="Azrou" {{ old('ville') == 'Azrou' ? 'selected' : '' }} id="azrou">Azrou</option>
              <option value="Beni Mellal" {{ old('ville') == 'Beni Mellal' ? 'selected' : '' }} id="beni-mellal">Beni Mellal</option>
              <option value="Berkane" {{ old('ville') == 'Berkane' ? 'selected' : '' }} id="berkane">Berkane</option>
              <option value="Berrechid" {{ old('ville') == 'Berrechid' ? 'selected' : '' }} id="berrechid">Berrechid</option>
              <option value="Boujdour" {{ old('ville') == 'Boujdour' ? 'selected' : '' }} id="boujdour">Boujdour</option>
              <option value="Casablanca" {{ old('ville') == 'Casablanca' ? 'selected' : '' }} id="casablanca">Casablanca</option>
              <option value="Chefchaouen" {{ old('ville') == 'Chefchaouen' ? 'selected' : '' }} id="chefchaouen">Chefchaouen</option>
              <option value="El Jadida" {{ old('ville') == 'El Jadida' ? 'selected' : '' }} id="el-jadida">El Jadida</option>
              <option value="Errachidia" {{ old('ville') == 'Errachidia' ? 'selected' : '' }} id="errachidia">Errachidia</option>
              <option value="Essaouira" {{ old('ville') == 'Essaouira' ? 'selected' : '' }} id="essaouira">Essaouira</option>
              <option value="Fes" {{ old('ville') == 'Fes' ? 'selected' : '' }} id="fes">Fes</option>
              <option value="Fnideq" {{ old('ville') == 'Fnideq' ? 'selected' : '' }} id="fnideq">Fnideq</option>
              <option value="Guelmim" {{ old('ville') == 'Guelmim' ? 'selected' : '' }} id="guelmim">Guelmim</option>
              <option value="Ifrane" {{ old('ville') == 'Ifrane' ? 'selected' : '' }} id="ifran">Ifrane</option>
              <option value="Kenitra" {{ old('ville') == 'Kenitra' ? 'selected' : '' }} id="kenitra">Kenitra</option>
              <option value="Khemisset" {{ old('ville') == 'Khemisset' ? 'selected' : '' }} id="khemisset">Khemisset</option>
              <option value="Khouribga" {{ old('ville') == 'Khouribga' ? 'selected' : '' }} id="khouribga">Khouribga</option>
              <option value="Ksar El Kebir" {{ old('ville') == 'Ksar El Kebir' ? 'selected' : '' }} id="ksar-el-kebir">Ksar El Kebir</option>
              <option value="Laayoune" {{ old('ville') == 'Laayoune' ? 'selected' : '' }} id="laayoune">Laayoune</option>
              <option value="Larache" {{ old('ville') == 'Larache' ? 'selected' : '' }} id="larache">Larache</option>
              <option value="Marrakech" {{ old('ville') == 'Marrakech' ? 'selected' : '' }} id="marrakech">Marrakech</option>
              <option value="Meknes" {{ old('ville') == 'Meknes' ? 'selected' : '' }} id="meknes">Meknes</option>
              <option value="Mohammedia" {{ old('ville') == 'Mohammedia' ? 'selected' : '' }} id="mohammedia">Mohammedia</option>
              <option value="Nador" {{ old('ville') == 'Nador' ? 'selected' : '' }} id="nador">Nador</option>
              <option value="Ouarzazate" {{ old('ville') == 'Ouarzazate' ? 'selected' : '' }} id="ouarzazate">Ouarzazate</option>
              <option value="Oujda" {{ old('ville') == 'Oujda' ? 'selected' : '' }} id="oujda">Oujda</option>
              <option value="Rabat" {{ old('ville') == 'Rabat' ? 'selected' : '' }} id="rabat">Rabat</option>
              <option value="Safi" {{ old('ville') == 'Safi' ? 'selected' : '' }} id="safi">Safi</option>
              <option value="Sidi Kacem" {{ old('ville') == 'Sidi Kacem' ? 'selected' : '' }} id="sidi-kacem">Sidi Kacem</option>
              <option value="Sidi Slimane" {{ old('ville') == 'Sidi Slimane' ? 'selected' : '' }} id="sidi-slimane">Sidi Slimane</option>
              <option value="Settat" {{ old('ville') == 'Sidi Slimane' ? 'selected' : '' }} id="settat">Settat</option>
              <option value="Skhirat" {{ old('ville') == 'Skhirat' ? 'selected' : '' }} id="skhirat">Skhirat</option>
              <option value="Tan-Tan" {{ old('ville') == 'Tan-Tan' ? 'selected' : '' }} id="tan-tan">Tan-Tan</option>
              <option value="Tangier" {{ old('ville') == 'Tangier' ? 'selected' : '' }} id="tangier">Tangier</option>
              <option value="Taourirt" {{ old('ville') == 'Taourirt' ? 'selected' : '' }} id="taourirt">Taourirt</option>
              <option value="Taroudant" {{ old('ville') == 'Taroudant' ? 'selected' : '' }} id="taroudant">Taroudant</option>
              <option value="Taza" {{ old('ville') == 'Taza' ? 'selected' : '' }} id="taza">Taza</option>
              <option value="Temara" {{ old('ville') == 'Temara' ? 'selected' : '' }} id="temara">Temara</option>
              <option value="Tetouan" {{ old('ville') == 'Tetouan' ? 'selected' : '' }} id="tetouan">Tetouan</option>
              <option value="Boumerdès" {{ old('ville') == 'Boumerdès' ? 'selected' : '' }} id="boumerdes">Boumerdès</option>
              <option value="Moulay Bousselham" {{ old('ville') == 'Moulay Bousselham' ? 'selected' : '' }} id="moulay-bousselham">Moulay Bousselham</option>
              <option value="Tiznit" {{ old('ville') == 'Tiznit' ? 'selected' : '' }} id="tiznit">Tiznit</option>
              <option value="Tinghir" {{ old('ville') == 'Tinghir' ? 'selected' : '' }} id="tinghir">Tinghir</option>
              <option value="Inezgane" {{ old('ville') == 'Inezgane' ? 'selected' : '' }} id="inezgane">Inezgane</option>
              <option value="Tarfaya" {{ old('ville') == 'Tarfaya' ? 'selected' : '' }} id="tarfaya">Tarfaya</option>

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
