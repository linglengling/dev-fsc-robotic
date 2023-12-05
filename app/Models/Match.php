<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use \DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Match extends Model  {

use SoftDeletes, HasFactory;
public $with = ['matchMatchTeams'];
public $table = 'matches';

protected $dates = [
'created_at',
    'updated_at',
    'deleted_at',
];

protected $fillable = [
'season_id',
    'field',
    'time',
    'red_score',
    'blue_score',
    'is_finished',
    'n_o',
    'created_at',
    'updated_at',
    'deleted_at',
];

protected function serializeDate(DateTimeInterface $date)
{
    



return $date->format('Y-m-d H:i:s');
    
}
public function matchScoreDetails()
{
    



return $this->hasMany(ScoreDetail::class, 'match_id', 'id');
    
}
public function matchMatchTeams()
{
    



return $this->hasMany(MatchTeam::class, 'match_id', 'id');
    
}
public function season()
{
    



return $this->belongsTo(Season::class, 'season_id');
    
}

}