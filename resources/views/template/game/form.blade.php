<form action="{{ $action }}" method="POST">
  @csrf

  @include('template.form.floating', [
      'type' => 'text',
      'id' => 'name',
      'name' => 'name',
      'label' => 'Name',
      'value' => $game ? $game->name : '',
      'class' => ['parent' => 'mb-3'],
      'extra' => ['input' => 'required autofocus'],
  ])

  @include('template.form.floating', [
      'type' => 'select',
      'id' => 'options',
      'name' => 'options[]',
      'label' => 'Options',
      'placeholder' => 'Select options',
      'options' => implode('', $game_options),
      'class' => ['parent' => 'mb-3', 'input' => 'select2'],
      'extra' => ['input' => 'multiple'],
  ])

  @include('template.form.icon', [
      'id' => 'icon',
      'name' => 'icon',
      'label' => 'Icon',
      'value' => $game ? $game->icon : '',
      'class' => ['row' => 'mb-3', 'parent' => 'flex-fill'],
      'extra' => ['input' => 'required'],
  ])

  @include('template.form.color', [
      'id' => 'color',
      'name' => 'color',
      'label' => 'Color',
      'color' => $game ? $game->color : '#000000',
  ])

  <hr />

  <div class="d-flex">
    <button class="btn btn-outline-success ms-auto" type="submit"><i class="far fa-save me-2"></i>Save</button>
  </div>
</form>
