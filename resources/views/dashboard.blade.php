@extends('template.app')

@section('content')
  <div class="card">
    <div class="card-body">

      <h1 class="text-center">
        <i class="{{ env('APP_ICON') }} me-2 fa-rotate-by"
           style="--fa-rotate-angle: -25deg;"></i>
        Welcome to {{ config('app.name') }}
      </h1>

      <hr />

      <div class="row">
        <div class="col">
          <div class="card flex-fill border-card mb-3"
               style="--border-color:var(--bs-{{ $games->count() > 0 ? 'success' : 'danger' }})">
            <div class="card-body d-flex flex-wrap align-items-center">
              <span class="text-nowrap">
                <i class="fas fa-gamepad me-2"></i>
                {{ $games->count() }} game{{ $games->count() > 1 ? 's' : '' }} in<i class="fas fa-database ms-2"></i>
              </span>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card flex-fill border-card ms-xs-3 mb-3"
               style="--border-color:var(--bs-{{ $parties->count() > 0 ? 'success' : 'danger' }})">
            <div class="card-body d-flex flex-wrap align-items-center">
              <span class="text-nowrap">
                <i class="far fa-circle-play me-2"></i>
                {{ $parties->count() }} part{{ $parties->count() > 1 ? 'ies' : 'y' }} active
              </span>
            </div>
          </div>
        </div>
      </div>

      @if ($games->count() > 0)
        <div class="card">
          <div class="card-body pb-0">

            <h4 class="text-center"><i class="fas fa-flag-checkered me-2"></i>New game</h4>

            <hr />

            <div class="row row-cols-1 row-cols-sm-3 row-cols-lg-5">
              @foreach ($games as $game)
                <a class="col text-decoration-none"
                   href="{{ route('party.new', ['game' => $game->id]) }}">
                  <div class="card mb-3 border-card"
                       style="--border-color:{{ $game->color }}">
                    <div class="card-body text-nowrap text-center">
                      <i class="{{ $game->icon }} me-2"></i>{{ $game->name }}
                    </div>
                  </div>
                </a>
              @endforeach
            </div>

          </div>
        </div>
      @endif

      @if ($parties->count() > 0)
        <div class="card mt-3">
          <div class="card-body pb-0">

            <h4 class="text-center"><i class="far fa-circle-play me-2"></i>Parties active</h4>

            <hr />

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3">
              @foreach ($parties as $party)
                @if ($party->winner())
                  @continue
                @endif
                <a class="col text-decoration-none"
                   href="{{ route('party.play', ['id' => $party->id]) }}">
                  <div class="card mb-3 border-card"
                       style="--border-color:{{ $party->game->color }}">
                    <div class="card-body">
                      <div class="text-nowrap text-center">
                        <i class="{{ $party->game->icon }} me-2"></i>{{ $party->game->name }}
                      </div>
                      <h6 class="small text-secondary my-2">Players :</h6>
                      <ul class="list-group list-group-flush small">
                        @foreach ($party->users()->get() as $user)
                          <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto {{ $user->id === $party->current()->id ? 'fw-bold' : '' }}">
                              @if ($user->id === $party->current()->id)
                                <i class="fas fa-arrow-right me-2"></i>
                              @endif
                              {{ $user->name }}
                            </div>
                            <span
                                  class="badge text-bg-{{ ($winner = App\Models\_Yams::getWinner($party)) ? ($winner->id === $user->id ? 'success' : 'danger') : 'secondary' }} rounded-pill">
                              {{ App\Models\_Yams::calculTotal($user) }}
                            </span>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </a>
              @endforeach
            </div>

          </div>
        </div>
      @endif

    </div>
  </div>
@endsection
