@props([
    'error' => false,
    'for' => false,
])
<div class="form-control">
    <label @isset($for) for="{{ $for }}" @endisset @class(['label space-x-4', 'cursor-pointer' => $for])>
        <span {{ $label->attributes->class(['text-error' => $error])->merge(['class' => 'label-text']) }}>
            {{ $label }}
        </span>
        {{ $slot }}
    </label>
    @if ($error)
    <label @isset($for) for="{{ $for }}" @endisset @class(['label', 'cursor-pointer' => $for])>
        <span {{ $label->attributes->class(['text-error' => $error])->merge(['class' => 'label-text-alt']) }}>
            {{ $error }}
        </span>
    </label>
    @endif
</div>
