<?php

namespace App\Http\Livewire\Game;

use Livewire\Component;
use App\Models\Question;

class Clue extends Component
{
    /** @var Boolean $show Whether to show or hide the modal */
    public bool $show = true;

    public Question $question;

    /** @var Array $listeners List all listeners this component needs to keep track of */
    protected $listeners = [
        'viewClue',
    ];

    /**
     * Function for when the listener event is tripped
     *
     * @param Question $id The eager loaded question collection
     * @return void
     * @throws 404 if no question found with that ID
     **/
    public function viewClue(Question $question)
    {
        if ( !$question->count() ) {
            abort(404);
            return;
        }

        $this->fill(['question' => $question]);

        $this->show = true;
    }

    public function render()
    {
        return view('livewire.game.clue');
    }
}
