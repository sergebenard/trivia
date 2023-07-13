@props([
    'open' => false,
    'name' => 'accordion-default',
])
<div {{ $attributes->class(['collapse', 'open' => $open]) }}>
    <input type="radio"
        name="{{ $name }}"
        @checked($open) />

    <div {{ $title->attributes->merge(['class' => 'collapse-title']) }}>
        {{ $title }}
    </div>

    <div class="collapse-content">
        {{ $slot }}
    </div>
</div>
