@extends('template.app')

@section('content')
  <div class="card">
    <div class="card-body">

      <h1 class="text-center">
        <i class="fas fa-dice me-2 fa-rotate-by" style="--fa-rotate-angle: -25deg;"></i>
        Welcome to {{ config('app.name') }}
      </h1>

      <hr />


    </div>
  </div>
@endsection
