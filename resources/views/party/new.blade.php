@extends('template.app')

@section('content')
  <div class="card">
    <div class="card-body">

      <h1><i class="{{ $game->icon }} fa-2xs me-3"></i>{{ $title }}</h1>

      <hr />

      <form action="{{ route('party.store') }}" method="POST">
        @csrf

        <input type="hidden" name="game_id" value="{{ $game->id }}" />

        {!! implode('', $template_options) !!}

        <div class="card">
          <div class="card-body pb-0">

            <div class="d-flex align-items-center">
              <h4 class="d-flex align-items-center">
                <i class="fas fa-person fa-xs me-2"></i>
                <span>Players</span>
              </h4>
              <div class="d-flex align-items-center ms-auto">
                @include('template.form.switch', [
                    'id' => 'random',
                    'label' => 'Randomize players order',
                    'active' => false,
                    'class' => ['label' => 'mb-0 ms-2', 'parent' => 'me-3'],
                    'extra' => ['input' => 'name="random"'],
                ])
                <button type="button" class="btn btn-outline-primary btn-add-row ms-3" data-bs-toggle="tooltip"
                  data-bs-placement="left" title="Add" data-row-container="#players">
                  <i class="fas fa-person-circle-plus"></i>
                </button>
              </div>
            </div>

            <hr />

            <div id="players" class="row-list sortable" data-empty-msg="No player yet">
              <div class="row row-clone d-none mb-3">
                <div class="col-auto d-flex align-items-center">
                  <i class="fas fa-bars sort-handle" style="cursor:grab;"></i>
                </div>
                <div class="col">
                  @include('template.form.floating', [
                      'type' => 'select',
                      'id' => 'players-uid',
                      'name' => 'players[uid]',
                      'label' => 'Player',
                      'placeholder' => 'Select player',
                      'options' => '',
                      'class' => ['input' => 'select-player'],
                      'extra' => [
                          'input' => sprintf(
                              'data-required="true" data-tags="true" data-ajax--url="%s" data-ajax--data-type="json" data-minimum-input-length="2"',
                              route('user.get')),
                      ],
                  ])
                </div>
                <div class="col-auto d-flex align-items-center justify-content-end">
                  <button type="button" class="btn btn-outline-danger btn-remove-row">
                    <i class="far fa-trash-alt"></i>
                  </button>
                </div>
              </div>
              @include('template.alert', [
                  'color' => 'secondary',
                  'class' => null,
                  'content' => 'No player yet',
              ])
            </div>

          </div>
        </div>

        <hr />

        <div class="d-flex">
          <button type="submit" class="btn btn-outline-success mx-auto">
            <i class="fas fa-play me-2"></i>Start
          </button>
        </div>

      </form>

    </div>
  </div>
@endsection
