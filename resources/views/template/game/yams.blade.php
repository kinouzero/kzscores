<div class="card {{ $user->pivot->current ? 'border-success' : '' }}">
  <div class="card-body">

    <div class="d-flex align-items-center">
      <img class="rounded me-2"
           src="{{ \Creativeorange\Gravatar\Facades\Gravatar::get($user->email) }}"
           style="width: 35px;height:35px;" />
      <h4 class="mb-0">{{ $user->name }}</h4>
      @if ($user->pivot->current)
        <span class="badge bg-success ms-auto small">Your turn</span>
      @endif
    </div>

    <hr />

    <form class="min-one-input max-one-input yam-form"
          action="{{ route('party.next', ['id' => $party->id]) }}"
          method="POST">
      @csrf

      <div class="d-flex flex-column">
        @foreach ($numbers as $i => $key)
          @include('template.form.floating', [
              'type' => 'number',
              'id' => sprintf('%s-%s', $key, $user->id),
              'name' => sprintf('inputs[%s]', $key),
              'label' => $i,
              'value' => ($value =
                  $score && $score->pluck($key)->filter()->first()
                      ? $score->pluck($key)->filter()->first()
                      : null),
              'class' => ['parent' => $i !== 6 ? 'mb-3' : '', 'input' => 'limit-value yam-number'],
              'extra' => [
                  'input' => sprintf(
                      'min="0" max="%s" modulo="%s" %s',
                      $i * 5,
                      $i,
                      $user->pivot->current && !$value ? '' : 'disabled'),
              ],
          ])
        @endforeach

        <hr />

        @include('template.form.floating', [
            'type' => 'text',
            'id' => sprintf('input-%s-total-numbers', $user->id),
            'name' => 'total-numbers',
            'label' => 'Total numbers',
            'value' => '0',
            'class' => ['parent' => 'mb-3', 'input' => 'yam-total-numbers'],
            'extra' => ['input' => 'disabled'],
        ])
        @include('template.form.floating', [
            'type' => 'text',
            'id' => sprintf('input-%s-total-bonus', $user->id),
            'name' => 'total-bonus',
            'label' => 'Bonus',
            'value' => '0',
            'class' => ['input' => 'yam-total-bonus'],
            'extra' => ['input' => 'disabled'],
        ])

        <hr />

        @foreach ($figures as $key => $props)
          @include('template.form.floating', [
              'type' => 'number',
              'id' => sprintf('figure-%s-%s', $key, $user->id),
              'name' => sprintf('inputs[%s]', $key),
              'label' => $props['label'],
              'value' => ($value =
                  $score && $score->pluck($key)->filter()->first()
                      ? $score->pluck($key)->filter()->first()
                      : null),
              'class' => ['parent' => $key !== 'chance' ? 'mb-3' : '', 'input' => 'limit-value yam-figure'],
              'extra' => [
                  'input' => sprintf(
                      'min="%s" max="%s" %s %s',
                      $props['min'],
                      $props['max'],
                      isset($props['modulo']) ? sprintf('modulo="%s"', $props['modulo']) : '',
                      $user->pivot->current && !$value ? '' : 'disabled'),
              ],
          ])
        @endforeach

        <hr />

        @include('template.form.floating', [
            'type' => 'text',
            'id' => sprintf('input-%s-total-figures', $user->id),
            'name' => 'total-figures',
            'label' => 'Total figures',
            'value' => '0',
            'class' => ['parent' => 'mb-3', 'input' => 'yam-total-figures'],
            'extra' => ['input' => 'disabled'],
        ])

        @include('template.form.floating', [
            'type' => 'text',
            'id' => sprintf('input-%s-total', $user->id),
            'name' => 'total',
            'label' => 'Total',
            'value' => '0',
            'class' => ['input' => 'yam-total'],
            'extra' => ['input' => 'disabled'],
        ])

        @if ($user->pivot->current)
          <hr />

          <div class="row">
            <div class="col d-flex">
              <button class="btn btn-outline-danger d-flex align-items-center flex-fill {{ $user->pivot->order === 1 && $score->count() === 0 ? 'disabled' : '' }}"
                      type="button">
                <i class="far fa-circle-left me-auto"></i>
                <span>Cancel</span>
              </button>
            </div>
            <div class="col d-flex">
              <button class="btn btn-outline-success d-flex align-items-center flex-fill"
                      type="submit">
                <span>Next</span>
                <i class="far fa-circle-right ms-auto"></i>
              </button>
            </div>
          </div>
        @endif

      </div>

    </form>

  </div>
</div>
