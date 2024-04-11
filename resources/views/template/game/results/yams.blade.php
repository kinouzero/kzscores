<canvas id="winner"
        data-type="bar"
        data-url="{{ route('chart.winner', ['id' => $party->id]) }}"
        data-label="Score">
  @include('template.alert', [
      'color' => 'danger',
      'class' => 'mb-0 text-center',
      'content' => 'Your browser does not support the canvas element',
  ])
</canvas>
