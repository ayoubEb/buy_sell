@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-12">
      <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="page-title mb-0 font-size-18">nouveau stock</h4>

          <div class="page-title-right">
              <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item active">nouveau stock</li>
              </ol>
          </div>

      </div>
  </div>
</div>
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

              <div class="d-flex justify-content-between">
                <a href="{{ route('categorie.index') }}" class="btn btn-primary waves-effect waves-light">
                  retour
                </a>

                <button type="submit" class="btn btn-success waves-effect waves-light">
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
