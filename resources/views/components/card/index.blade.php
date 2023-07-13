@props([
    'body' => false,
    'title' => false,
    'actions' => false,
])
<div {{ $attributes->merge(['class' => 'card']) }} >
    <div @if($body) {{ $body->attributes->merge(['class' => 'card-body']) }} @else class="card-body" @endif>
        @if($title)
            {{ $title }}
        @endif

        @if($body)
        {{ $body }}
        @else
        {{ $slot }}
        @endif

        @if($actions)
        <div {{ $actions->attributes->merge(['class' => 'card-actions']) }}>
            {{ $actions }}
        </div>
        @endif
    </div>
</div>
