@props([
    'error' => false,
    'for' => false,
])
<div class="form-control">
    <label @isset($for) for="{{ $for }}" @endisset @class(['label', 'cursor-pointer' => $for])>
        <span {{ $label->attributes->class(['text-error' => $error])->merge(['class' => 'label-text']) }}>
            {{ $label }}
        </span>
    </label>

    {{ $slot }}

    @if ($error)
    <label @isset($for) for="{{ $for }}" @endisset @class(['label', 'cursor-pointer' => $for])>
        <span {{ $label->attributes->class(['text-error' => $error])->merge(['class' => 'label-text-alt']) }}>
            {{ $error }}
        </span>
    </label>
    @endif
</div>
