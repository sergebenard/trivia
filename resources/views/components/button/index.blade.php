@props([
    'disabled' => false,
])

<button {{ $attributes->class(['btn-disabled' => $disabled])->merge(['class' => 'btn', 'type' => 'button']) }} @disabled($disabled)>
    {{ $slot }}
</button>
