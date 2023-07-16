@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <!-- Begin modal.dialog component -->
    @if($title)
    <div {{ $title->attributes }}>
        {{ $title }}
    </div>
    @endif

    <div {{ $content->attributes->merge(['class' => 'mt-4']) }}>
        {{ $content }}
    </div>

    @if($footer)
    <div {{ $footer->attributes }}>
        {{ $footer }}
    </div>
    @endif
    <!-- End modal.dialog component -->
</x-modal>
