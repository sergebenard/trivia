<?php

namespace App\Http\Livewire\Welcome\GameSettings;

use App\Models\Episode;
use Livewire\Component;

class SpecificDate extends Component
{
    public $years = [];
    public $year = 0;

    public $months = [];
    public $month = 0;

    public $days = [];
    public $day = 0;

    public $episodes = [];
    public $episode = 0;

    public $max_questions = 61;

    protected $rules = [
        'year' => 'required|int',
        'month' => 'required|int',
        'day' => 'required|int',
    ];

    public function mount() {

        // $years = Episode::selectRaw('id, DISTINCT YEAR(air_date) AS year')
        //             ->pluck('year', 'id');
        // dd($years);

        $years = Episode::selectRaw('DISTINCT YEAR(air_date) AS years')
                    ->orderBy('years')
                    ->pluck('years');

        $this->fill(['years' => $years ]);
    }

    public function updatedYear(Int $year)
    {
        // sleep(10);

        $this->reset([
                'months',
                'month',
                'days',
                'day',
                'episodes',
                'episode',
            ]);

        $months = Episode::selectRaw('DISTINCT MONTH(air_date) as months')
                    ->orderBy('months')
                    ->whereYear('air_date', $year)
                    ->pluck('months');

        $this->fill(['months' => $months]);
    }

    public function updatedMonth(Int $month)
    {

        $this->reset([
                'days',
                'day',
                'episodes',
                'episode',
            ]);

        $days = Episode::selectRaw('DISTINCT DAY(air_date) as days')
                    // ->withCount('questions')
                    ->orderBy('days')
                    ->whereYear('air_date', $this->year)
                    ->whereMonth('air_date', $month)
                    ->pluck('days');

        $this->fill(['days' => $days]);
    }

    public function updatedDay(Int $day)
    {
        $timestamp = mktime(0, 0, 1, $this->month, $this->day, $this->year);

        $episodes = Episode::select('id', 'air_date')
                            ->whereDate('air_date', date('Y-m-d', $timestamp))
                            ->withCount('questions AS question_count')
                            ->get();

        $this->fill(['episodes' => $episodes]);
    }

    public function render()
    {
        return view('livewire.welcome.game-settings.specific-date');
    }

}
