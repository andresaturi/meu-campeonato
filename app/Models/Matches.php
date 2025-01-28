<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    protected $fillable = [
        'championship_id',
        'stage_id',
        'home_team_id',
        'away_team_id',
        'home_team_goals',
        'away_team_goals',
        'home_team_extra_time',
        'away_team_extra_time',
        'home_team_penalties',
        'away_team_penalties',
        'winner_id',
        'match_date',
    ];

    public function team()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }
}
