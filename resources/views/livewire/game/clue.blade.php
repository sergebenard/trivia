<div class="flex-1">
    <x-button :square="true" wire:click="viewClue" class="w-full text-xl text-white btnHeaderShadow btn-primary" :disabled="$show_answer">
        @if($show_answer)
            &nbsp;
        @else
        {{ $question->clue_value }}
        @endif
    </x-button>

    <x-modal.dialog name="show-clue"
        wire:model='show'
        class="flex flex-col min-h-full px-3 py-2 space-y-3 bg-blue-700">
        <x-slot:title class="flex text-2xl font-bold text-white btnHeaderShadow">
            <div class="grow">
                {{ Str::headline($question->category) }}
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-lg">
                    $
                </div>

                <div>
                    {{ $question->clue_value }}
                </div>
            </div>
        </x-slot:title>

        <x-slot:content class="flex items-center flex-1 text-6xl font-bold text-center text-yellow-300 uppercase btnTextShadow">
            {{ $question->answer }}
        </x-slot:content>

        <x-slot:footer class="w-full">
            <div class="w-full">
                @if($show_answer)
                <div class="py-3 text-3xl text-center uppercase text-blue-50">
                    {{ $question->question }}
                </div>
                <div class="flex w-full join">
                    <x-button wire:click.prevent="processAnswer(true)" class="flex-1 btn-success join-item">
                        Correct
                    </x-button>

                    <x-button wire:click.prevent="processAnswer(false)" class="flex-1 btn-error join-item">
                        Wrong
                    </x-button>
                </div>

                @else
                <x-button wire:click.prevent="viewAnswer" class=" btn-ghost text-blue-50 btn-block">
                    View Answer
                </x-button>
                @endif
            </div>
        </x-slot:footer>
    </x-modal.dialog>
</div>
