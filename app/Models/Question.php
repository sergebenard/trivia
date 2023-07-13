<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, HasUuids;

    /** @var string $table The table associated with the model */
    protected $table = 'questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'round',
        'clue_value',
        'daily_double_value',
        'category',
        'comments',
        'answer',
        'question',
        'air_date',
        'notes',
        'episode_id',
    ];

    /** @var array $casts Set the attributes' casting */
    protected $casts = [
        'air_date' => 'date',
        'round' => 'integer',
        'clue_value' => 'integer',
        'daily_double_value' => 'integer',
    ];

}
