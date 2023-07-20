<div class="flex-1">
    <!-- Clue ID: {{ $question->id }} -->
    <x-button :square="true" wire:click="viewClue" class="w-full text-xl text-white btnHeaderShadow btn-primary" :disabled="$show_answer">
        @if($show_answer)
            &nbsp;
        @else
        {{ $question->clue_value }}
        @endif
    </x-button>
    @if($show)
    <x-modal.dialog :escape_closes="false" :click_outside_closes="false" name="show-clue"
        wire:model='show'
        class="flex flex-col min-h-full px-3 py-2 space-y-3 bg-blue-700 max-h-20">
        <x-slot:title class="flex text-2xl font-bold text-white btnHeaderShadow">
            <div class="flex-1">
                {{ Str::title( Str::ascii($question->category) ) }}
            </div>
            <div class="flex items-baseline gap-2">
                <div class="text-lg">
                    $ <!-- Dollar Sign! -->
                </div>

                <div>
                    {{ $question->clue_value }}
                </div>
            </div>
        </x-slot:title>

        <x-slot:content class="flex flex-1 overflow-y-auto text-6xl font-bold text-center text-yellow-300 uppercase btnTextShadow">

        {{-- <x-slot:content class="flex items-center flex-1 overflow-y-auto text-6xl font-bold text-center text-yellow-300 uppercase btnTextShadow"> --}}
                <span class="block px-4 my-auto">{{ Str::ascii( $question->answer ) }}</span>
        </x-slot:content>

        <x-slot:footer class="w-full">
            <div class="w-full">
                @if($show_answer)
                <div class="py-3 text-3xl text-center uppercase text-blue-50">
                    {{ $question->question }}
                </div>
                <div class="flex w-full join">
                    <x-button wire:click.prevent="processAnswer(true)" class="flex-1 btn-success join-item" autofucus>
                        Correct
                    </x-button>

                    <x-button wire:click.prevent="processAnswer(false)" class="flex-1 btn-error join-item">
                        Wrong
                    </x-button>
                </div>

                @else
                <div class="flex w-full join">
                    <x-button wire:click.prevent='hideClue' class="flex-1 join-item btn-outline btn-info">
                        Cancel
                    </x-button>
                    <x-button wire:click.prevent="viewAnswer" class="flex-1 join-item btn-info" autofocus>
                        View Answer
                    </x-button>
                </div>
                @endif
            </div>
        </x-slot:footer>
    </x-modal.dialog>
    @endif
</div>
