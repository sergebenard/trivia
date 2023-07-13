<div>
    <div class="join">
        <select wire:model='year'
            class="select select-bordered join-item"
            name="specific-date-year"
            id="specific-date-year">
            <option disabled
                value="0"
                @selected($year == 0)>
                Select a year
            </option>

            @foreach ($years as $yearloop)
                <option value="{{ $yearloop }}"
                    @selected($year == $yearloop)>{{ $yearloop }}</option>
            @endforeach
        </select>

        @if ($months)
            <select wire:model='month'
                class="select select-bordered join-item"
                name="specific-date-month"
                id="specific-date-month">
                <option disabled
                    value="0"
                    @selected($month == 0)>
                    Select a month
                </option>

                @foreach ($months as $monthloop)
                    <option value="{{ $monthloop }}"
                        @selected($month == $monthloop)>{{ $monthloop }} -
                        {{ date('F', mktime(0, 0, 0, $monthloop, 1)) }}</option>
                @endforeach
            </select>
        @endif

        @if ($days)
            <select wire:model='day'
                class="select select-bordered join-item"
                name="specific-date-day"
                id="specific-date-day">
                <option disabled
                    value="0"
                    @selected($day == 0)>
                    Select a day
                </option>

                @foreach ($days as $dayloop)
                    <option value="{{ $dayloop }}"
                        @selected($day == $dayloop)>{{ $dayloop }}</option>
                @endforeach
            </select>
        @endif

        @if ($month == 0)
            <select class="select select-bordered join-item"
                wire:loading>
                <option disabled
                    selected
                    value="0">
                    Loading...
                </option>
            </select>
        @endif
    </div>

    @error('episode_go')
        There was an error: {{ $message }}
    @enderror
    <div>

    </div>

    @if ($episodes)
    @php
        $max_questions_per_episode = 61;
    @endphp
    <div class="block pt-4">
        <div class="box-border bg-base-200 stats text-base-content">
            @foreach ($episodes as $episode)
                <div class="stat">
                    <div class="stat-title">Episode Questions</div>

                    <div class="stat-value">{{ $episode->question_count }}</div>

                    <div class="stat-desc">
                        {{ ceil(($episode->question_count / $max_questions_per_episode) * 100) }}%

                        of a possible

                        {{ $max_questions_per_episode }}
                    </div>

                    <div class="flex gap-3 pt-2 stat-desc">
                        <a class="btn btn-primary" href="{{ route('game.create', $episode->id) }}">
                            Play >
                        </a>
                        {{-- <label for="game_select">
                            Play this game
                        </label> --}}

                        {{-- <input type="radio" value="{{ $episode->id }}" id="game_select" name="game_select" class="toggle toggle-primary" @checked($loop->first) /> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
