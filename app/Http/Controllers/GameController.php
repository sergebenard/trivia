<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Question;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(String $episode_id)
    {
        //

        // $questions = Question::select(
        //                     'id',
        //                     'round',
        //                     'clue_value',
        //                     'daily_double_value',
        //                     'category',
        //                     'answer',
        //                     'question'
        //                 )
        //                 ->where('episode_id', $episode_id)
        //                 ->where('round', 1)
        //                 ->orderBy('category', 'asc')
        //                 ->orderBy('clue_value', 'asc')
        //                 ->get();

        return view('game.index', ['episode_id' => $episode_id]);
        // return view('game.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
