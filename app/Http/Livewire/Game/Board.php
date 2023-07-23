<?php

namespace App\Http\Livewire\Game;

use App\Models\Episode;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Board extends Component
{
    public Episode|null $episode = null;

    public Collection|null $questions = null;

    public Question|null $question = null;

    public String|null $previous_game_id = null;
    public String|null $next_game_id = null;

    /** @var Int $round_count Keeping count of the current round */
    public $round_count = 1; // Keep track of the current round

    // Keep track of point multiplier
    public $point_multiplier = 200;

    // Keep track of the date where the multiplier changes!
	public Carbon $multiplier_change_date;

    public Int $max_rows = 6;     // Maximum possible rows
    public Int $max_columns = 6;  // Maximum possible

    public int $player_points = 0; // Keep track of the player's points

    protected $listeners = [
        'addPoints',
    ];

    public function addPoints(Int $points) {
        $this->player_points += $points;
    }

    public function mount(Episode $episode)
    {
        $questions = $this->getRoundQuestions($episode);

        if ( count($questions) < 1) {
            // dd('Did not load');
            abort(404);
            return;
        }

        $previous_game_id = Episode::whereDate('air_date', '<', $episode->air_date)
                                ->orderBy('air_date', 'DESC')
                                ->pluck('id')
                                ->first();

        $next_game_id = Episode::whereDate('air_date', '>', $episode->air_date)
                                ->orderBy('air_date', 'ASC')
                                ->pluck('id')
                                ->first();

        $this->fill([
                'questions' => $questions,
                'episode' => $episode,
                'previous_game_id' => $previous_game_id,
                'next_game_id' => $next_game_id,
            ]);

        $this->multiplier_change_date = Carbon::createFromDate(2001, 9, 23);

        // Set up the multiplier
		$this->set_clue_value_multiplier( $this->questions[0] );
    }

    public function resetBoard() {

        $this->reset(
                    'questions',
                    // 'player_points',
                );
    }

    public function changeRound(int $round) {
        $this->resetBoard();

        if( $round >= 1 && $round <= 2 ) {
            $this->round_count = $round;

            $questions = $this->getRoundQuestions( $this->episode );

            if ($questions->count() < 1) {
                // dd('Did not load');
                abort(404);
                return;
            }

            $this->set_clue_value_multiplier( $questions[0] );

            $this->fill([
                    'questions' => $questions,
                ]);
        }
    }

    public function getRoundQuestions(Episode $episode) {
        return Question::select(
                        'id',
                        'round',
                        'clue_value',
                        'daily_double_value',
                        'category',
                        'answer',
                        'question',
                        'air_date',
                    )
                ->where('episode_id', $episode->id)
                ->where('round', $this->round_count)
                ->orderBy('category', 'asc')
                ->orderBy('clue_value', 'asc')
                ->get();
    }

	public function set_clue_value_multiplier(Question $question ) {

		// $this->add_comment_to_board("Inside set_clue_value_multiplier...");

		// If show air date before September 23, 2001, do this
		if( $question->air_date->lessThan( $this->multiplier_change_date ) ) {

			// If in round 2, do this
			if ( $question->round < 2 ) {
				// Make the point_multiplier 100
				$this->point_multiplier = 100;
				return;
			}

			// Make the point_multiplier 200
			$this->point_multiplier = 200;
			return;
		}
		else {
			if ( $question->round < 2 ) {
				$this->point_multiplier = 200;
				return;
			}

			$this->point_multiplier = 400;
			return;
		}

	}

    public function get_row_cost(int $row_count) : int
	{
		return $row_count * $this->point_multiplier;
	}

    public function render()
    {
        // return $this->game_board;
        return view('game.board');
    }
}
