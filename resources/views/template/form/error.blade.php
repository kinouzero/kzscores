@if (is_array($errors->get($key)))
  @foreach ($errors->get($key) as $msg)
    <p class="small text-danger">{{ $msg }}</p>
  @endforeach
@elseif(is_string($errors->get($key)))
  <div class="small text-danger">{{ $msg }}</div>
@endif
