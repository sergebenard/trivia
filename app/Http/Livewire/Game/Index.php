<?php

namespace App\Http\Livewire\Game;

use App\Models\Episode;
use Livewire\Component;
use App\Models\Question;

class Index extends Component
{
    /** @var Episode $episode Holding the episode collection */
    public Episode $episode;

    /**
     * Mount and initialize the component
     *
     * Mount the component and initialize all of the variables
     *
     * @param Episode $episode Eager load an Episode collection
     * @return void
     * @throws 404
     **/
    public function mount(Episode $episode)
    {
        if ( !$episode->count() ) {
            abort(404);
        }

        // $this->fill([
        //     'episode' => $episode,
        // ]);
    }

    public function render()
    {
        return view('livewire.game.index');
    }
}
