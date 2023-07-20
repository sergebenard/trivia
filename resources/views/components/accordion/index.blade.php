@props([
    'open' => false,
    'name' => 'accordion-default',
    'content' => false,
])
<div {{ $attributes->class(['collapse', 'open' => $open]) }}>
    <input type="radio"
        name="{{ $name }}"
        @checked($open) />

    <div {{ $title->attributes->merge(['class' => 'collapse-title']) }}>
        {{ $title }}
    </div>

    <div @if($content) {{ $content->attributes->merge(['class' => 'collapse-content max-w-full overflow-x-auto']) }} @else class="max-w-full overflow-x-auto collapse-content" @endif>
        @if($content)
        {{ $content }}
        @else
        {{ $slot }}
        @endif

    </div>
</div>
