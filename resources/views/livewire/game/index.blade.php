@slot('header')
    Play Game
@endslot

<div>
    @livewire('game.board', ['episode' => $episode->id])

    @livewire('game.clue')
</div>
