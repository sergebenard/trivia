@props([
    'disabled' => false,
    'active' => false,
    'square' => false,
])

<button {{ $attributes->class([
        'btn-active' => $active,
        'btn-disabled opacity-60 cursor-not-allowed' => $disabled,
        'btn' => !$square,
        'btn-square' => $square,
    ])->merge(['type' => 'button']) }} @disabled($disabled)>
    {{ $slot }}
</button>
