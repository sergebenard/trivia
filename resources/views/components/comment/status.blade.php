<x-comment>
    {{ $slot }}
    Round: {{ $question->round}}
    Row: {{ $rowCount}}
    Column: {{ $columnCount}}
    category: {{ $question->category}}
    current_category: {{ $currentCategory}}
    clue_value: {{ $question->clue_value}}
    point_multiplier: {{ $pointMultiplier}};
</x-comment>
