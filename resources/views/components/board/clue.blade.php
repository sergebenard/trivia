<div class="flex flex-1" wire:key="clue-square-{{ $question->id }}">
    <x-button class="flex-1" wire:click.prevent="viewClue">
        {{ $question->clue_value }}
    </x-button>

    @livewire('game.clue', ['question' => $question])

</div>
