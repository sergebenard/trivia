<?php

namespace App\Http\Livewire\Game;

use Livewire\Component;
use App\Models\Question;

class Clue extends Component
{
    /** @var array $rules Holds the validation rules */
    // protected $rules = [
    //     'show' => 'required',
    // ];

    /** @var Boolean $show Whether to show or hide the modal */
    public bool $show = false;
    public bool $show_answer = false;

    public Question $question;

    /**
     * Function for when the listener event is tripped
     *
     * @return void
     **/
    public function viewClue()
    {
        $this->show = true;
    }

    function viewAnswer() {
        $this->show_answer = true;
    }

    /**
     *
     *
     * Add or subtract the points for this question
     *
     * @param boolean $got_it_right Whether the player got it right or not
     * @return void
     **/
    public function processAnswer(bool $got_it_right)
    {
        $this->emitTo('game.board',
                'addPoints',
            ($got_it_right) ?
                $this->question->clue_value :
                $this->question->clue_value * -1
            );

        $this->show = false;
    }

    public function render()
    {
        return view('livewire.game.clue');
    }
}
