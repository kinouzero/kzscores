@extends('template.app')

@section('content')
  <div class="card">
    <div class="card-body pb-0">

      <h1 class="d-flex text-center align-items-center">
        <i class="fas fa-{{ $party->game->icon }} fa-2xs me-2"></i>{{ $party->game->name }}
      </h1>

      <hr />

      <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
        @foreach ($sheets as $sheet)
          <div class="col mb-3">
            {!! $sheet !!}
          </div>
        @endforeach
      </div>

      @vite(sprintf('resources/js/%s.js', $party->game->key))

      <script>
        window.onload = function() {
          var el = document.querySelector('.current-player');
          window.scrollTo({
            top: el.offsetTop,
            behavior: 'smooth'
          });
        }
      </script>

    </div>
  </div>
@endsection
