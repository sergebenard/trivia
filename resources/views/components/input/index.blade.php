@props([
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'checked' => false,
    'error' => false,
])
<input {{ $attributes->class(['input-error' => $error])->merge(['type' => 'text', 'class' => 'input']) }} @disabled($disabled) @required($required) @readonly($readonly) @checked($checked) />
