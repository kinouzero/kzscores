@extends('template.app')

@section('content')
  <div class="card">
    <div class="card-body">

      <h1><i class="far fa-pencil-alt fa-2xs me-3"></i>{{ $title }}</h1>

      <hr />

      @include('template.game.form', [
          'action' => $game ? route('game.update', ['id' => $game->id]) : route('game.store'),
      ])

    </div>
  </div>
@endsection
