@props([
    'disabled' => false,
    'required' => false,
    'checked' => false,
])
<input type="checkbox" {{ $attributes->merge(['class' => 'toggle']) }} @disabled($disabled) @required($required) @checked($checked) />
