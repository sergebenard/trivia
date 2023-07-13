<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasUuids, HasFactory;

    protected $fillable = [
        'air_date',
    ];

    protected $casts = [
        'air_date' => 'date',
    ];

    /**
     * Get all of the questions for the Episode
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'episode_id', 'id');
    }
}
