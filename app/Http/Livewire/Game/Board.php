<?php

namespace App\Http\Livewire\Game;

use App\Models\Episode;
use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Board extends Component
{
    public Collection $questions;

    /** @var Int $round_count Keeping count of the current round */
    public $round_count = 1; // Keep track of the current round

    public $point_multiplier = 200;
	public Carbon $multiplier_change_date;

    public Int $row_count = 0; // Keeping track of current row
    public Int $column_count = 0; // Keeping track of current column

    public String $current_category = ''; // To check if category has changed

    public Int $max_rows = 6;     // Maximum possible rows
    public Int $max_columns = 6;  // Maximum possible columns

    public Int $max_questions = 61; // Maximum possible questions

    public String $game_board = "";

    public function mount(Episode $episode)
    {

        $questions =    Question::select(
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

        if ($questions->count() < 1) {
            // dd('Did not load');
            abort(404);
            return;
        }

        $this->fill(['questions' => $questions]);

		$this->multiplier_change_date = Carbon::createFromDate(2001, 9, 23);

		// Set up the multiplier
		$this->set_clue_value_multiplier( $this->questions[0] );

        $this->buildGameBoard();
    }

	public function set_clue_value_multiplier(Question $question ) {

		$this->add_comment_to_board("Inside set_clue_value_multiplier...");

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

	public function get_row_cost(Question $question) : int
	{
		return $this->row_count * $this->point_multiplier;
	}

    public function buildGameBoard()
    {

        $this->add_opening_board_tags_to_board();

        foreach ($this->questions as $question) {

            $this->add_status_comment("New loop beginning...", $question);

            // If this loop instance has a new category do this
            if( $this->is_new_category(($question)) ) {
				$this->add_comment_to_board("buildGameBoard() -> This is a new category.");

				// The row_count is between 1 and max_rows
                if( $this->row_count >= 1 && $this->row_count < $this->max_rows ) {
					$this->add_comment_to_board("buildGameBoard() -> The row_count is between 1 and " . $this->max_rows);
					$this->add_blank_square_to_board( $this->max_rows - $this->row_count );
                }

                // Reset the row_count to its default
                $this->row_count = 1;

                // Iterate the column_count
                $this->column_count++;
            }

            // If the row count is at one, we need to put up the new category
            if( $this->row_count === 1 ) {
				$this->add_comment_to_board("buildGameBoard() -> The row_count is exactly 1, and will now add category text to the board.");
                $this->add_category_text_to_board( $question );
            }

            // If this clue is in the right spot, do this
            if( $this->is_correct_square( $question ) ) {
                $this->add_comment_to_board("buildGameBoard() -> is_correct_square equals to 'true'.");

                // Add the clue to the board
				$this->add_comment_to_board("buildGameBoard() -> Adding the clue to the board.");
                $this->add_clue_to_board( $question );

                // Iterate the row_count variable
                $this->row_count++;
            }
            else {
                $this->add_comment_to_board("buildGameBoard() -> is_correct_square equals to 'false'.\n
						Will now loop through until the clue value
						matches row_count calculation.");

				// Loop through rows to find the correct row for this instance
                while( !$this->is_correct_square( $question ) ) {
					$this->add_comment_to_board("buildGameBoard() -> Looping;
							row_count: " . $this->row_count . "
							calculation: " . $this->get_row_cost($question) . "
							clue_value: " . $question->clue_value);

                    // Add a blank square to the board
                    $this->add_blank_square_to_board();

                    // Iterate the row_count variable
                    $this->row_count++;

                    if( $this->row_count >= $this->max_rows ) {
                        break;
                    }
                }

				// Now show the clue value in its correct square!
				$this->add_clue_to_board( $question );
				$this->row_count++;
            }

            // Add current loop category to current_category variable
            $this->current_category = $question->category;

            // If the board is full, let's do a sanity check and stop in case it won't do it by itself
            if( $this->row_count >= $this->max_rows && $this->column_count > $this->max_columns ) {
                break;
            }
        }
        $this->add_closing_board_tags_to_board();
    }

	public function is_new_category(Question $question) {
		$this->add_comment_to_board("Inside is_new_category...");

		return !Str::is(
					Str::lower( Str::of($question->category)->trim() ),
					Str::lower( Str::of($this->current_category)->trim() )
				);
	}

    public function is_correct_square(Question $question)
    {
		$calculation = $this->get_row_cost($question) == $question->clue_value;

		$this->add_comment_to_board("Inside is_correct_square; " . $this->get_row_cost($question) . " " . $question->clue_value);

        return $calculation;
    }

	public function add_status_comment(String $message = "", Question $question) {
		$this->add_comment_to_board($message . "
                        Round: " . $question->round . "
						Row: " . $this->row_count . "
						Column: " . $this->column_count . "
						category: " . $question->category . "
						current_category: " . $this->current_category . "
						clue_value: " . $question->clue_value . "
						Calculation: " . $this->get_row_cost( $question ) ."
                        point_multiplier: " . $this->point_multiplier);
	}


    public function add_comment_to_board(String $comment)
    {
        $this->game_board .= '<!-- ' . $comment . ' -->';
    }

    public function add_category_text_to_board(Question $question)
    {
		$this->add_comment_to_board("Inside add_category_text_to_board...");

        $this->game_board .= '<div class="overflow-y-auto text-center max-h-12">' . $question->category . '</div>';
    }

    public function add_clue_to_board(Question $question)
    {
		$this->add_comment_to_board("Inside add_clue_to_board...");

        $this->game_board .= '<x-button wire:click.prevent="$emit(\'viewClue\', \'' .$question->id .'\')">' . $question->clue_value . '</x-button>';
    }

    public function add_blank_square_to_board(Int $span = 1)
    {
		$this->add_comment_to_board("Inside add_blank_square_to_board... \n span: " . $span);

        switch ($span) {

            case 2:
                $this->game_board .= '<div class="row-span-2">&nbsp;</div>';
                break;

            case 3:
                $this->game_board .= '<div class="row-span-3">&nbsp;</div>';
                break;

            case 4:
                $this->game_board .= '<div class="row-span-4">&nbsp;</div>';
                break;

            case 5:
                $this->game_board .= '<div class="row-span-5">&nbsp;</div>';
                break;

            case 1:
            default:
                $this->game_board .= '<div class="row-span-1">&nbsp;</div>';
                break;
        }
    }

    public function add_opening_board_tags_to_board()
    {
        $this->add_comment_to_board("!! Starting the board !!");

        $this->game_board .= '<div class="max-w-5xl pt-6 mx-auto">
        <div class="grid items-center justify-center w-full grid-flow-col grid-cols-6 grid-rows-6 gap-2 p-2 bg-base-300">';
    }

    public function add_closing_board_tags_to_board()
    {
        $this->game_board .= '</div></div>';

        $this->add_comment_to_board("!! Ending the board !!");
    }

    public function render()
    {
        return $this->game_board;
    }
}
