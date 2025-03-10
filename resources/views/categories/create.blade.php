@extends('layouts.master')

@section('content')
<h6 class="title-header mb-2">
  <a href="{{ route('categorie.index') }}" class="btn btn-brown-outline px-4 py-1">
    <span class="mdi mdi-arrow-left-thick mdi-18px"></span>
  </a>
  nouveau catégorie
</h6>
  <div class="card">
    <div class="card-body p-2">
      <div class="row justify-content-center">
        <div class="col mb-2">
            <div class="form-group">
              <label for="" class="form-label">voir</label>
              <img id="fileVoir" src="" class="img-fluid d-block" alt="Image de fiche" />
            </div>
        </div>
        <div class="col-lg-8">
          <form action="{{ route('categorie.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row row-cols-2">
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">Nom <span class="text-danger"> * </span> </label>
                  <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
                  @error('nom')
                    <strong class="invalid-feedback">
                        {{ $message }}
                    </strong>
                  @enderror
                </div>
              </div>
              <div class="col mb-2">
                <div class="form-group">
                  <label for="" class="form-label">image</label>
                  <input type="file" name="img" id="fileImg" class="form-control" class="form-control" value="">
                </div>
              </div>

            </div>
            <div class="form-group mb-2">
              <label for="" class="form-label">Description</label>
              <textarea name="description" rows="10" class="form-control">{{ old("description")}}</textarea>
            </div>

            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-vert waves-effect waves-light">
                  <span>Enregistrer</span>
              </button>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
@endsection
@section('script')
  <script>
    $(document).ready(function () {
      fileImg.onchange = evt => {
        const [file] = fileImg.files
        if (file) {
          fileVoir.src = URL.createObjectURL(file)
        }
      }
    });
  </script>
@endsection
