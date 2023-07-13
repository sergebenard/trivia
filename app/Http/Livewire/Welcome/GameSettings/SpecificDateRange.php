<?php

namespace App\Http\Livewire\Welcome\GameSettings;

use Livewire\Component;
use App\Models\Question;

class SpecificDateRange extends Component
{

    public $yearsMin = [];
    public $yearMin = 0;

    public $yearsMax = [];
    public $yearMax = 0;

    protected $rules = [
        'yearMin' => 'required|int',
        'yearMax' => 'required|int',
    ];

    public function mount() {

        $years = Question::selectRaw('DISTINCT YEAR(air_date) AS years')
                    // ->whereYear('air_date', '>=', 1990)
                    ->pluck('years');

        $this->fill(['yearsMin' => $years]);
    }

    public function updatedYearMin(Int $year)
    {
        // sleep(10);

        $this->reset([
                'yearsMax',
                'yearMax',
            ]);

        $years = Question::selectRaw('DISTINCT YEAR(air_date) AS years')
            ->whereYear('air_date', '>=', $year)
            ->pluck('years');

        $this->fill(['yearsMax' => $years]);
    }

    public function render()
    {
        return view('livewire.welcome.game-settings.specific-date-range');
    }
}
