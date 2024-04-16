@extends('template.app')

@section('content')
  <div class="card">
    <div class="card-body">

      <h1><i class="{{ $game->icon }} fa-2xs me-3"></i>{{ $title }}</h1>

      <hr />

      <form action="{{ route('party.store') }}"
            method="POST">
        @csrf

        <input name="game_id"
               type="hidden"
               value="{{ $game->id }}" />

        {!! implode('', $template_options) !!}

        <div class="card">
          <div class="card-body pb-0">

            <div class="row">

              <h4 class="col order-1 d-flex align-items-center flex-nowrap mb-0">
                <i class="fas fa-person fa-xs me-2"></i>
                <span>Players</span>
              </h4>

              <div
                   class="col order-3 order-sm-2 d-flex align-items-center justify-content-start justify-content-sm-center">
                @include('template.form.switch', [
                    'id' => 'random',
                    'label' => 'Randomize players order',
                    'active' => false,
                    'class' => ['label' => 'mb-0 ms-2 text-nowrap'],
                    'extra' => ['input' => 'name="random"'],
                ])
              </div>

              <div class="col order-2 order-sm-3 d-flex align-items-center justify-content-end">
                <button class="btn btn-outline-primary btn-add-row"
                        data-bs-toggle="tooltip"
                        data-bs-placement="left"
                        data-row-container="#players"
                        type="button"
                        title="Add">
                  <i class="fas fa-person-circle-plus"></i>
                </button>
              </div>

            </div>

            <hr />

            <div class="row-list sortable"
                 id="players"
                 data-empty-msg="No player yet">
              <div class="row row-clone d-none mb-3">
                <div class="col-auto d-flex align-items-center">
                  <i class="fas fa-bars sort-handle"
                     style="cursor:grab;"></i>
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
                  <button class="btn btn-outline-danger btn-remove-row"
                          type="button">
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
          <button class="btn btn-outline-success mx-auto"
                  type="submit">
            <i class="fas fa-play me-2"></i>Start
          </button>
        </div>

      </form>

    </div>
  </div>
@endsection
