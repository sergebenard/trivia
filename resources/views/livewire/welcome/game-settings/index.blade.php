<div class="space-y-4 ">
    <p>Please select the type of game you want to play:</p>

    <x-accordion name="game-settings" :open="true" class="bg-base-200">
        <x-slot:title>
            <h3 class="text-lg font-medium ">You want to play a game from a specific date.</h3>
        </x-slot:title>

        @livewire('welcome.game-settings.specific-date')
    </x-accordion>

    <x-accordion name="game-settings" class="bg-base-200">
        <x-slot:title>
            <h3 class="text-lg font-medium ">You want to play a random game between specific years.</h3>
        </x-slot:title>

        @livewire('welcome.game-settings.specific-date-range')
    </x-accordion>
</div>
