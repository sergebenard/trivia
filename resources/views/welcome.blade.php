<x-app-layout>
    @slot('header')
        Welcome
    @endslot

    {{-- <form method="POST"
        name="go-game"
        id="go-game"
        action="{{ route('game.create') }}"
        enctype="multipart/form-data">
        @csrf --}}

        <div class="max-w-4xl pt-6 mx-auto space-y-4">


            <x-card class="border border-gray-300 card-compact">
                <x-slot:title>
                    <h2 class="text-xl font-medium">Step 1</h2>
                </x-slot:title>

                <x-accordion :open="true"
                    class="bg-base-200">
                    <x-slot:title>
                        <h3 class="text-lg font-medium">If you're playing alone</h3>
                    </x-slot:title>

                    <x-card class="card-compact">
                        <x-slot:title>
                            Step 1: Who You Are
                        </x-slot:title>
                        <x-slot:body>
                            @livewire('welcome.single-player.settings')
                        </x-slot:body>
                    </x-card>
                </x-accordion>

                <x-accordion class="bg-base-200">
                    <x-slot:title>
                        <h3 class="text-lg font-medium">If you have other players in the same room</h3>
                    </x-slot:title>
                    I'm working on it!
                </x-accordion>

                <x-accordion class="bg-base-200">
                    <x-slot:title>
                        <h3 class="text-lg font-medium">If you have other players online</h3>
                    </x-slot:title>
                    I'm working on it!
                </x-accordion>
            </x-card>

            <x-card class="border border-gray-300 card card-compact">
                <x-slot:title>
                    <h2 class="text-lg font-medium">Step 2:</h2>
                </x-slot:title>

                <x-slot:body>
                    @livewire('welcome.game-settings')
                </x-slot:body>
            </x-card>
        </div>
    {{-- </form> --}}
</x-app-layout>
