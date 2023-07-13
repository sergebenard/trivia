<x-app-layout>
    @slot('header')
        Play Game
    @endslot

    {{-- @dd( $questions ) --}}
    @livewire('game.index', ['episode_id' => $episode_id])

</x-app-layout>
