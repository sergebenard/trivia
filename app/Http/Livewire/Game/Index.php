<?php

namespace App\Http\Livewire\Game;

use Livewire\Component;
use App\Models\Question;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class Index extends Component
{
    public Collection $questions;

    public Int $row_count = 1; // Keeping track of current row
    public Int $column_count = 1; // Keeping track of current column

    public String $current_category = ''; // To check if category has changed

    public Int $max_rows = 6;     // Maximum possible rows
    public Int $max_columns = 6;  // Maximum possible columns

    public Int $max_questions = 61; // Maximum possible questions

    public String $game_board = "";

    public function mount(String $episode_id)
    {

        $questions =    Question::select(
								'id',
								'round',
								'clue_value',
								'daily_double_value',
								'category',
								'answer',
								'question'
							)
						->where('episode_id', $episode_id)
						->where('round', 1)
						->orderBy('category', 'asc')
						->orderBy('clue_value', 'asc')
						->get();

        if ($questions->count() < 1) {
            abort(404);
            return;
        }

        $this->fill(['questions' => $questions]);

        $this->buildGameBoard();
    }

    public function buildGameBoard()
    {

        $this->add_opening_board_tags_to_board();

        foreach ($this->questions as $question) {
            $this->add_status_comment("New loop beginning...", $question);

            // Check if we have a new category
            if ( $this->is_new_category( $question ) ) {
				$this->add_status_comment("Is a new category!", $question);

				// If the row_count is higher or equal to max, or if it's the first row, do this
				if( $this->row_count > $this->max_rows || $this->row_count === 1 ) {

					// Reset the row count
					$this->row_count = 1;

					// New category means adding the category name to the board!
					$this->add_category_text_to_board($question);

					$this->row_count++;

					// We're now in a new column!
					$this->column_count++;
				}
				elseif( $this->row_count <= $this->max_rows ) {
					$this->add_blank_square_to_board( $this->max_rows - $this->row_count );

					$this->row_count = 1;
					$this->column_count++;

					// New category means adding the category name to the board!
					$this->add_category_text_to_board($question);

					$this->row_count++;

				}

				// $this->row_count++;
            }

			// Check if this question matches with row_count
            if ($this->is_correct_square($question)) {

				$this->add_status_comment("Clue value matches with row count.", $question);

                $this->add_clue_to_board($question);

                $this->row_count++; // Add a row
            } else {
				// Not a correct square!
				$this->add_status_comment("Clue value does not match with row count.", $question);

				// Loop through the questions to get all possible valid squares
				while( !$this->is_correct_square($question) ) {
					$this->add_comment_to_board("Looping through non-matching clues...");

					// If it's still possible to have valid squares, do this
					if ( $this->row_count <= $this->max_rows ) {
						$this->add_status_comment("Might still have valid squares!", $question);

						// Add a blank square to the board
						$this->add_blank_square_to_board();
						// Add one to the row count
						$this->row_count++;
					}
					else { // If it is not possible to have any more valid squares, break
						$this->add_status_comment("Impossible to still have valid squares!", $question);
						break;
					}
				}
            }

            // Set the current category with the current loop's category
            $this->current_category = $question->category;
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
		$this->add_comment_to_board("Inside is_correct_square...");

        return $this->row_count * 200 >= $question->clue_value;
    }

	public function add_status_comment(String $message = "", Question $question) {
		$this->add_comment_to_board($message . "
						Row: " . $this->row_count . "
						Column: " . $this->column_count . "
						category: " . $question->category . "
						current_category: " . $this->current_category . "
						clue_value: " . $question->clue_value . "
						Calculation: " . ($this->row_count) * 200 . "
					");
	}

    public function add_comment_to_board(String $comment)
    {
        $this->game_board .= '<!-- ' . $comment . ' -->';
    }

    public function add_category_text_to_board(Question $question)
    {
		$this->add_comment_to_board("Inside add_category_text_to_board...");

        $this->game_board .= '<div class="text-center">' . $question->category . '</div>';
    }

    public function add_clue_to_board(Question $question)
    {
		$this->add_comment_to_board("Inside add_clue_to_board...");

        $this->game_board .= '<x-button>' . $question->clue_value . '</x-button>';
    }

    public function add_blank_square_to_board(Int $span = 1)
    {
		$this->add_comment_to_board("Inside add_blank_square_to_board... \n span: " . $span);

        $this->game_board .=    '<div ';

        switch ($span) {

            case 2:
                $this->game_board .= ' class="row_span_2"';
                break;

            case 3:
                $this->game_board .= ' class="row_span_3"';
                break;

            case 4:
                $this->game_board .= ' class="row_span_4"';
                break;

            case 5:
                $this->game_board .= ' class="row_span_5"';
                break;

            case 1:
            default:
                $this->game_board .= ' class="row_span_1"';
                break;
        }

		$this->game_board .= '>&nbsp;</div>';
    }

    public function add_opening_board_tags_to_board()
    {
        $this->game_board .= '<div class="max-w-5xl pt-6 mx-auto">
        <div class="grid items-center justify-center w-full grid-flow-col grid-cols-6 grid-rows-6 gap-1 bg-base-300">';
    }

    public function add_closing_board_tags_to_board()
    {
        $this->game_board .= '</div></div>';
    }

    public function render()
    {
        return $this->game_board;
    }
}
