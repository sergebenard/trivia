<x-app-layout>
    @slot('header')
        Play Game
    @endslot

    {{-- @dd( $questions ) --}}

    <div class="max-w-5xl pt-6 mx-auto">
        <div class="grid items-center justify-center w-full grid-flow-col grid-cols-6 grid-rows-6 gap-1 bg-base-300">
            <!-- Questions: {{ count($questions) }} -->
            @php
                $column_count = 1;
                $row_count = 1;

                $old_category = $questions[0]->category;
                $old_clue_value = 0;

                $max_rows = 6;
                $max_columns = 6;
            @endphp
            @foreach ($questions as $question)
            <!--
                    Row: {{ $row_count }}
                    Column: {{ $column_count }}
                    category: {{ $question->category }}
                    clue_value: {{ $question->clue_value }}
                    Calculation: {{ ($row_count) * 200 }}
            -->

            @if ($old_category != $question->category && $row_count >= $max_rows)
            @php
                $row_count = 1;
                $column_count++;
            @endphp
            @elseif($old_category != $question->category && $row_count < $max_rows)
            @php
                $row_span_length = $max_rows - $row_count;
                $row_count = 1;
                $column_count++;
            @endphp

            <div @class([
                'row-span-2' => $row_span_length === 2,
                'row-span-3' => $row_span_length === 3,
                'row_span-4' => $row_span_length === 4,
                'row-span-5' => $row_span_length === 5,
            ])></div>

            {{-- @continue --}}
            {{-- @endif --}}

            @elseif( $row_count === 1 && $row_count * 200 >= $question->clue_value)
            <!-- We're at the first row, with a clue value equal or lower than its expected value; let's give em a category and a clue. -->
            <div class="text-center">{{ $question->category }}</div>
            <x-button>{{ $question->clue_value }}</x-button>

            @php
            $row_count++;
            @endphp

            @if( $row_count === 1 && $row_count * 200 < $question->clue_value)
            <div class="text-center">{{ $question->category }}</div>
            @while ($row_count * 200 <= $question->clue_value)
            <div></div>
            @php
            if ($row_count >= $max_rows) {
                $row_count = 1;
                break;
            }
            else {
                $row_count++;
            }
            @endphp
            @endwhile
            <x-button>{{ $question->clue_value }}</x-button>
            @endif

            @elseif ( $row_count > 1 && $row_count * 200 >= $question->clue_value)
            <x-button>{{ $question->clue_value }}</x-button>
            @php
            $row_count++;
            @endphp

            @else
            <div></div>
            @endif

            @php
                $old_category = $question->category;
                $old_clue_value = $question->clue_value;
            @endphp
            @endforeach

        </div>
    </div>

</x-app-layout>
