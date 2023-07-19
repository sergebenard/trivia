@slot('header')
    Play Game
@endslot

{{-- @dd( $questions ) --}}
@livewire('game.index', ['episode' => $episode->id])
