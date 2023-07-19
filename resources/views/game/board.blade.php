@php
    /** @var Int $round_count Keeping count of the current round */
    // $round_count = 1; // Keep track of the current round

    $row_count = 0; // Keeping track of current row
    $column_count = 0; // Keeping track of current column

    $current_category = ''; // To check if category has changed
@endphp

<div>
    <div class="max-w-5xl pt-6 mx-auto">

        <div class="grid w-full grid-cols-3 gap-3">
            <x-card class="justify-center bg-primary card card-compact">
                <div class="flex items-center w-full gap-4">
                    <div class="flex-1 text-right text-indigo-200">
                        Player 1
                    </div>

                    <div class="flex items-center gap-2 text-xl font-medium text-indigo-100 btnHeaderShadow">
                        <span class="text-lg ">
                            $
                        </span>
                        <span class="text-2xl">
                            {{ $player_points }}
                        </span>
                    </div>
                </div>
            </x-card>
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
                    <div class="flex items-center justify-center h-12 overflow-y-auto text-center bg-primary max-h-12 text-indigo-50 btnHeaderShadow">
                        {{ $question->category }}
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

                    @while (!$this->is_correct_square( $question ))
                        <div>&nbsp;</div>

                        @php
                            $row_count++;
                        @endphp

                        {{-- let's keep things sane! --}}
                        @if( $row_count >= $max_rows )
                            @break
                        @endif
                    @endwhile

                    {{-- Now show the clue value in its correct square! --}}
                    @livewire('game.clue', ['question' => $question])

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


            {{-- // If the board is full, let's do a sanity check and stop in case it won't do it by itself --}}
            {{-- if( $this->row_count >= $this->max_rows && $this->column_count > $this->max_columns ) { --}}
                {{-- break; --}}
            {{-- } --}}
        {{-- } --}}
        {{-- $this->add_closing_board_tags_to_board(); --}}
</div>
