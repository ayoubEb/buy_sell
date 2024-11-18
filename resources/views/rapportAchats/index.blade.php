@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
      <h4 class="page-title mb-0 font-size-18">s</h4>
    </div>
  </div>
</div>

<div class="row row-cols-4">
  @foreach ($ligneRapports as $item)
    <div class="col">
      <div class="card {{ $item->mois == date('m-Y') ? 'bg-soft-success' : '' }}">
        <div class="card-body p-2">
          <h6 class="text-center mb-2">
            {{ $item->mois }}
          </h6>
          <h6 class="text-center title">
            {{ $item->count . ' | ' . number_format($item->sum , 2 , "," ," ") . ' DH ' }}
          </h6>
          <div class="d-flex justify-content-center">
            <a href="{{ route('rapportAchat.show',$item->mois) }}" class="btn btn-darkLight waves-effect waves-light">
              voir
            </a>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection