<div>
    @if($question)
    <x-modal.dialog name="show-clue" wire:model='show' class="px-3 py-2 space-y-3 bg-blue-700">
        <x-slot:title class="text-lg font-medium text-white">
            {{ Str::headline( $question->category ) }}
        </x-slot:title>

        <x-slot:content class="w-full text-3xl text-center text-yellow-300 uppercase">
            This is the clue.
        </x-slot:content>

        <x-slot:footer>
            This is the footer.
        </x-slot:footer>
    </x-modal.dialog>
    @endif
</div>
