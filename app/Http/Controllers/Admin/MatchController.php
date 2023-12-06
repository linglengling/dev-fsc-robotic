<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Models\Match;
use App\Models\Season;
use App\Models\ScoreDetail;
use App\Models\Team;
use App\Models\MatchTeam;
use App\Http\Requests\StoreMatchRequest;
use App\Http\Requests\UpdateMatchRequest;
use App\Http\Requests\MassDestroyMatchRequest;
use Illuminate\Support\Facades\DB;
class MatchController extends Controller  {

use CsvImportTrait;



function index()
{
    abort_if(Gate::denies('match_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

     $matches = Match::with(['season'])->get();

    return view('admin.matches.index', compact('matches'));
}

function calculateScore(Match $match){
   //$match->load('season', 'matchScoreDetails', 'matchMatchTeams');

   $scoreDetail_red = $match->matchScoreDetails->where('alliance', 1)->first() ;
   $scoreDetail_blue = $match->matchScoreDetails->where('alliance', 2)->first() ;
   $matchMatchTeams_red = $match->matchMatchTeams->where('alliance', 1)->toArray();
   $matchMatchTeams_blue = $match->matchMatchTeams->where('alliance', 2)->toArray();
//   dd($matchMatchTeams_blue);
   $matchMatchTeams_red_1 =  array_pop($matchMatchTeams_red); 
   $matchMatchTeams_red_2 = array_pop($matchMatchTeams_red);
   $matchMatchTeams_blue_1 = array_pop($matchMatchTeams_blue);
   $matchMatchTeams_blue_2 = array_pop($matchMatchTeams_blue);
//    $match->toArray();

// dd($scoreDetail_red);
    return view('admin.matches.calscore', 
        compact('match', 'scoreDetail_red','scoreDetail_blue',
        'matchMatchTeams_red_1','matchMatchTeams_red_2',
        'matchMatchTeams_blue_1','matchMatchTeams_blue_2'
      ));
    
}

public function sendScore(Request $request)
{
     //$scoreDetail = new ScoreDetail;
     $scoreDetail_arr  =  $request->input('scoreDetail');
     ScoreDetail::find($scoreDetail_arr['id'])->update($scoreDetail_arr);

     $match_arr  =  $request->input('match');
     if($scoreDetail_arr['alliance'] == 1)
             Match::find($match_arr['id'])->update(['red_score' => $match_arr['red_score'] ]);
    if($scoreDetail_arr['alliance'] == 2)
             Match::find($match_arr['id'])->update(['blue_score' => $match_arr['blue_score'] ]);


    $matchMatchTeams1_arr  =  $request->input('matchMatchTeams1');
    MatchTeam::find($matchMatchTeams1_arr['id'])->update($matchMatchTeams1_arr);   
    $matchMatchTeams2_arr  =  $request->input('matchMatchTeams2');
    MatchTeam::find($matchMatchTeams2_arr['id'])->update($matchMatchTeams2_arr);           
 //    $scoreDetail->fill($request->input('scoreDetail'))->save();
    return ['status' => 'Message Sent!'];
}

public function finishedMatch(Match $match)
{
    $match->is_finished = 1;
    $match->update();
    return redirect()->route('admin.matches.calculateScore', $match->id);
}

function create()
{
    abort_if(Gate::denies('match_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');



    $seasons = Season::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');



    return view('admin.matches.create', compact('seasons'));
}
function store(StoreMatchRequest $request)
{
    



  $match = Match::create($request->all());
  // tao 2 Score detail 1= red, 2 = blue
   $scoreDetail_red = ScoreDetail::insert([
      'match_id' => $match->id,
       'alliance' => 1
    ]);
   $scoreDetail_blue = ScoreDetail::insert([
      'match_id' => $match->id,
       'alliance' => 2
    ]);

   return redirect()->route('admin.matches.index');
    
}
function edit(Match $match)
{
    abort_if(Gate::denies('match_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');



    $seasons = Season::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
//     $teams= Team::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
//     foreach( $teams as $k => $v) {
//         echo $k;
//       $t =  Team::where('id', $k)->first();
//    //   dd($t);
//       $teams[$k] = $v."( ".$t->n_order." )";
//     }, 

    $teams_r = Team::where([
        'season_id' => $match->season->id
        ])->get();
        $teams = array();
    foreach($teams_r as $t) {
        $teams[$t->id] = $t->name."( ".$t->n_order." )" ;
       // array_push($teams[$t->id],  );
    }

    $match->load('season');
    $r_team =[];
    $b_team =[];
    foreach ($match->matchMatchTeams as $matchTeam) {
        if($matchTeam->alliance == 1 ) array_push($r_team, $matchTeam->team_id);
        if($matchTeam->alliance == 2 ) array_push($b_team, $matchTeam->team_id);
    }
    $team_1_1_id = isset($r_team[0])?$r_team[0]:0;
     $team_1_2_id = isset($r_team[1])?$r_team[1]:0;
     
     $team_2_1_id = isset($b_team[0])?$b_team[0]:0;
     $team_2_2_id = isset($b_team[1])?$b_team[1]:0;
    return view('admin.matches.edit', compact('match', 'seasons','teams','team_1_1_id','team_1_2_id','team_2_1_id','team_2_2_id'));
}
function update(UpdateMatchRequest $request, Match $match)
{
    $original_array = [$request->team_1_1_id,$request->team_1_2_id,$request->team_2_1_id,$request->team_2_2_id ];
    $temp_array = array_unique($original_array);
    $duplicates = sizeof($temp_array) != sizeof($original_array);
//    var_dump($original_array);    exit();
    if ($duplicates ) return redirect()->back()->with('message', 'Chọn đội không đúng - Có 1 đội bị lặp lại' );
    DB::table('match_teams')->where('match_id', '=', $match->id)->delete();
//    $match->matchMatchTeams->delete() ; 
//    $match->matchMatchTeams->forceDelete();
     $matchTeam_1_1 = MatchTeam::insert([
      'match_id' => $match->id,
         'team_id' => $request->team_1_1_id,
       'alliance' => 1
    ]);
    $matchTeam_1_2 = MatchTeam::insert([
      'match_id' => $match->id,
         'team_id' => $request->team_1_2_id,
       'alliance' => 1
    ]);
    
    $matchTeam_2_1 = MatchTeam::insert([
      'match_id' => $match->id,
         'team_id' => $request->team_2_1_id,
       'alliance' => 2
    ]);
    $matchTeam_2_2 = MatchTeam::insert([
      'match_id' => $match->id,
         'team_id' => $request->team_2_2_id,
       'alliance' => 2
    ]);
    $match->update($request->all());


    return redirect()->route('admin.matches.index');
    
}
function show(Match $match)
{
    abort_if(Gate::denies('match_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');




$match->load('season', 'matchScoreDetails', 'matchMatchTeams');

    return view('admin.matches.show', compact('match'));
}
function destroy(Match $match)
{
    abort_if(Gate::denies('match_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');



    $match->matchScoreDetails()->delete();
    $match->delete();
    return back();
    
}
function massDestroy(MassDestroyMatchRequest $request)
{
    



    $matches = Match::find(request('ids'));

    foreach ($matches as $match) {
    $match->delete();
    }

    return response(null, Response::HTTP_NO_CONTENT);
    
}

}