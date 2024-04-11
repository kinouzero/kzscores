<form action="{{ $action }}" method="POST">
  @csrf

  @include('template.form.floating', [
      'type' => 'text',
      'id' => 'name',
      'name' => 'name',
      'label' => 'Name',
      'value' => $option ? $option->name : '',
      'class' => ['parent' => 'mb-3'],
      'extra' => ['input' => 'required autofocus'],
  ])

  @include('template.form.floating', [
      'type' => 'select',
      'id' => 'type',
      'name' => 'type',
      'label' => 'Type',
      'options' => implode('', $types),
      'placeholder' => 'Select type',
      'class' => ['parent' => 'mb-3', 'input' => 'select2 change-type'],
      'extra' => [
          'input' => sprintf(
              'required data-card="#card-%s" data-btn="#btn-%s"',
              $option ? $option->id : '0',
              $option ? $option->id : '0'),
      ],
  ])

  <div class="card mb-3 {{ $option && $option->type === 'select' ? '' : 'd-none' }}"
    id="card-{{ $option ? $option->id : '0' }}">
    <div class="card-body pb-0">

      <h3 class="text-center"><i class="fas fa-sitemap me-2"></i>Properties</h3>

      <div id="option-properties" class="row-list" data-empty-msg="No property yet">

        <hr />

        {!! implode('', $template_properties) !!}

      </div>

    </div>
  </div>

  <hr />

  <div class="d-flex">
    <button id="btn-{{ $option ? $option->id : '0' }}" class="btn btn-outline-secondary btn-add-row" type="button"
      data-row-container="#option-properties">
      <i class="fas fa-list-ul me-2"></i>Add property</button>
    <button class="btn btn-outline-success ms-auto" type="submit"><i class="far fa-save me-2"></i>Save</button>
  </div>
</form>
