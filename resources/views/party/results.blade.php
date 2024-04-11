@extends('template.app')

@section('content')
  <div class="card">
    <div class="card-body">

      <h4><i class="fas fa-trophy fa-xs me-2"></i>Results</h4>

      <hr />

      <div class="d-flex alig-items-center justify-content-center">
        <i class="fas fa-trophy me-2"></i>
        {{ $party->winner()->name }}
      </div>

      {!! $template !!}

    </div>
  </div>
@endsection
