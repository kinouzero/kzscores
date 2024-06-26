@extends('template.app')

@section('content')
  <div class="card">
    <div class="card-body">

      <h1 class="d-flex text-center align-items-center">
        <i class="fas fa-cogs fa-2xs me-2"></i>Options
        <div class="ms-auto d-flex align-items-center">
          <a class="btn btn-outline-secondary" href="{{ route('option.create') }}" title="Create" data-bs-toggle="tooltip"
            data-bs-placement="left"><i class="fas fa-plus"></i></a>
        </div>
      </h1>

      <hr />

      <table class="datatable w-100" data-page-length={{ App\Models\User::getUserTableLength(auth()->user()) }}>
        <thead>
          <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Properties</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        @if ($options)
          <tbody>
            @foreach ($options as $option)
              <tr>
                <td>{{ $option->name }}</td>
                <td>{{ $option->type }}</td>
                <td>{{ implode(', ', array_values($option->properties())) }}</td>
                <td class="text-end">
                  <div class="btn-group">
                    <a class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Edit"
                      href="{{ route('option.edit', ['id' => $option->id]) }}"><i class="fas fa-pencil-alt"></i></a>
                    <a class="btn btn-outline-danger btn-form" data-bs-toggle="tooltip" title="Delete" href="#"
                      data-form="#delete-option-{{ $option->id }}"><i class="far fa-trash-alt"></i></a>
                  </div>
                  <form id="delete-option-{{ $option->id }}"
                    action="{{ route('option.destroy', ['id' => $option->id]) }}" method="POST">
                    @csrf
                    @method('DELETE')
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        @endif
      </table>
    </div>
  </div>
@endsection
