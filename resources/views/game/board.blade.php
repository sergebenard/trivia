@php
    /** @var Int $round_count Keeping count of the current round */
    // $round_count = 1; // Keep track of the current round

    $row_count = 0; // Keeping track of current row
    $column_count = 0; // Keeping track of current column

    $current_category = ''; // To check if category has changed
@endphp

<div data-theme="board">
    <div class="max-w-5xl pt-6 mx-auto">

        <div class="flex items-center gap-4">
            <x-card class="justify-center max-w-xs bg-primary card card-compact">
                <div class="flex items-center w-full gap-4">
                    <div class="flex-1 text-right text-primary-content">
                        Player 1
                    </div>

                    <div class="flex items-center gap-2 text-xl font-medium text-primary-content btnHeaderShadow">
                        <span class="text-lg ">
                            $
                        </span>
                        <span class="text-2xl">
                            {{ $player_points }}
                        </span>
                    </div>
                </div>
            </x-card>

            <x-card class="card-compact ">
                <div class="flex items-center w-full gap-4">
                    <div class="flex-1 text-right text-primary">
                        Play round:
                    </div>

                    <div class="join">
                        @if($round_count == 1)
                        <span class="btn btn-primary join-item btn-active">
                            One
                        </span>

                        <x-button class="btn-primary join-item" :active="false" wire:click.prevent='changeRound(2)'>
                            Two
                        </x-button>
                        @elseif($round_count == 2)
                        <x-button class="btn-primary join-item" :active="false" wire:click.prevent='changeRound(1)'>
                            One
                        </x-button>

                        <span class="btn btn-primary join-item btn-active">
                            Two
                        </span>
                        @endif

                    </div>
                </div>
            </x-card>

            <a class="btn btn-primary btn-outline" href="{{ route('welcome') }}">
                New Game
            </a>
        </div>

        <div class="grid items-center justify-center w-full grid-flow-col grid-cols-6 grid-rows-6 gap-1 p-2 mt-3 bg-black">
            @foreach ($questions as $question)
                <x-comment.status
                    :question="$question"
                    :rowCount="$row_count"
                    :columnCount="$column_count"
                    :currentCategory="$current_category"
                    :pointMultiplier="$point_multiplier">

                    This is a new loop.

                </x-comment.status>

                {{-- If this loop instance has a new category, do this --}}
                @if(    !Str::is(Str::lower( Str::of($question->category)->trim() ),
                        Str::lower( Str::of($current_category)->trim() )
                    ))
                    <x-comment>This is a new category.</x-comment>

                    @if($row_count >= 1 && $row_count_difference = $row_count < $max_rows)
                        <x-comment>The row_count is between 1 and {{ $max_rows }}. Putting a div with class of row-span-{{ $row_count_difference }}.</x-comment>

                        <div @class([
                                        'row-span-1' => ($max_rows - $row_count === 1),
                                        'row-span-2' => ($max_rows - $row_count === 2),
                                        'row-span-3' => ($max_rows - $row_count === 3),
                                        'row-span-4' => ($max_rows - $row_count === 4),
                                        'row-span-5' => ($max_rows - $row_count === 5),
                                    ])>&nbsp;</div>
                    @endif

                    @php
                        // Reset the row_count to its default
                        // $this->row_count = 1;
                        $row_count = 1;

                        // Iterate the column_count
                        // $this->column_count++;
                        $column_count++;
                    @endphp
                {{-- }    --}}
                @endif

                @if($row_count === 1)
                    <!-- row_count is equal to 1. -->
                    <div class="flex h-16 overflow-x-auto overflow-y-auto text-center text-primary-content bg-primary btnHeaderShadow">
                        <span class="block mx-auto my-auto leading-normal">
                            {{ $question->category }}
                        </span>
                    </div>
                @endif

                {{-- Check if the current question in the loop matches with row_count --}}
                @if($this->get_row_cost($row_count) == $question->clue_value)
                    <x-comment>The clue matches the row_count!</x-comment>

                    @livewire('game.clue', ['question' => $question], key('clue-' . $question->id))
                    {{-- <x-board.clue :question="$question"></x-board> --}}

                    @php
                        $row_count++;
                    @endphp

                @else
                    <x-comment>!! The clue DOES NOT match the row_count !!</x-comment>

                    @while ($this->get_row_cost($row_count) != $question->clue_value && $row_count <= $max_rows)
                        <x-comment>The clue still DOES NOT match the row_count, which is: {{ $row_count }}</x-comment>

                        <div>&nbsp;</div>

                        @php
                            $row_count++;
                        @endphp

                        {{-- let's keep things sane! --}}
                        @if( $row_count > $max_rows )
                            @break
                        @endif
                    @endwhile

                    {{-- Now show the clue value in its correct square! --}}
                    @livewire('game.clue', ['question' => $question], key('clue-' . $question->id))

                    @php
                        $row_count++;
                    @endphp

                @endif

                @php
                    // Add current loop category to current_category variable
                    // $this->current_category = $question->category;

                    $current_category = $question->category;
                @endphp

                @if($row_count >= $max_rows && $column_count > $max_columns )
                    <x-comment>
                        !! Had to break the question loop programatically !!
                    </x-comment>
                    @break
                @endif
            @endforeach
</div>
