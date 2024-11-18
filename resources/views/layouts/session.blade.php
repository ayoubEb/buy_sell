@if (Session::has("success"))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-2"></i> {{ Session::get("success") }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@elseif (Session::has("update"))
  <div class="alert alert-primary alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-2"></i> {{ Session::get("update") }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@elseif (Session::has("destroy"))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="mdi mdi-check-all me-2"></i> {{ Session::get("destroy") }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
