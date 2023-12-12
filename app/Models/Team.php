<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use SoftDeletes, HasFactory;
    //public $with = ['teamMatchTeams'];
    public $table = 'teams';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'season_id',
        'name',
        'score',
        'created_at',
        'updated_at',
        'deleted_at',
        'n_order'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function teamMatchTeams()
    {
        return $this->hasMany(MatchTeam::class, 'team_id', 'id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id');
    }

    // public function getFullTeamNameAttribute() { 
    //     return $this->name . " ( ".$this->n_order ." ) ";
    // }
    // public function getFullNameAttribute() {
    //     return  $this->name . " ( ".$this->n_order ." ) ";
    // }
    // public function getNameAttribute($value) {
    // //    return $value;
    //     return $value . " ( ".$this->n_order ." ) ";
    // }
        /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    // public function setScoreAttribute($value)
    // {
    //     $this->attributes['score'] = strtolower($value);
    // }
    public function getScoreAttribute() {
        $teamMatchTeams = MatchTeam::where('team_id', '=', $this->id)->get();
        // lấy điểm tất cả các trận đấu của đội 
        $score_arr = [];
        foreach($teamMatchTeams as $teamMatchTeam) {
            if(isset($teamMatchTeam->match->is_finished) && $teamMatchTeam->match->is_finished == 0 ) continue;
            if($teamMatchTeam->alliance == 1 ) {
                
                if($teamMatchTeam->is_availaibe == 0 || $teamMatchTeam->is_banned == 1 ) {
                    array_push($score_arr,0 ); continue;
                }
                array_push($score_arr,$teamMatchTeam->match->red_score  );
            }
            if($teamMatchTeam->alliance == 2 ) {
                if($teamMatchTeam->is_availaibe == 0 || $teamMatchTeam->is_banned == 1 ) {
                    array_push($score_arr,0 ); continue;
                }
                array_push($score_arr,$teamMatchTeam->match->blue_score  );
            }
        }
    //     $str="";
    //    foreach($score_arr as $s) {
    //     $str .= " ".$s;
    //    }
    //    return $str;
    sort($score_arr);
    $score= 0;
     $x =0 ;   
    foreach($score_arr as $key=>$value) {
        if ($key == 0 && count($score_arr) !=1 ) //or whatever
             continue;
        $score = $score + $score_arr[$key];
        $x++;
    }

    
    if($score != 0)
        $score =  round($score / $x, 1) ;
    return $score;

        return $this->n_order . ' ' . $this->season_id;
    }

    public function getScore2Attribute() {
        $teamMatchTeams = MatchTeam::where('team_id', '=', $this->id)->get();
        // lấy điểm tất cả các trận đấu của đội 
        $score_arr = [];
        foreach($teamMatchTeams as $teamMatchTeam) {
            if($teamMatchTeam->alliance == 1 ) {
                
                if($teamMatchTeam->is_availaibe == 0 || $teamMatchTeam->is_banned == 1 ) {
                    array_push($score_arr,0 ); continue;
                }
                array_push($score_arr,$teamMatchTeam->match->red_score  );
            }
            if($teamMatchTeam->alliance == 2 ) {
                if($teamMatchTeam->is_availaibe == 0 || $teamMatchTeam->is_banned == 1 ) {
                    array_push($score_arr,0 ); continue;
                }
                array_push($score_arr,$teamMatchTeam->match->blue_score  );
            }
        }
        $str="";
       foreach($score_arr as $s) {
        $str .= " - ".$s;
       }
       return $str;
 
    }
}
