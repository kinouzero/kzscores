<div class="form-check {{ isset($class['parent']) ? $class['parent'] : '' }}">
  <input class="{{ isset($class['input']) ? $class['input'] : '' }}"
         id="{{ $id }}"
         name="{{ $name }}"
         data-toggle="toggle"
         data-onlabel="{!! $label['on'] !!}"
         data-offlabel="{!! $label['off'] !!}"
         data-onstyle="outline-{{ $color['on'] }}"
         data-offstyle="outline-{{ $color['off'] }}"
         type="checkbox"
         @if ($value) value="{{ $value }}" @endif
         @if ($active) checked @endif />
</div>
