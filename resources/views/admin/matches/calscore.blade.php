@extends('layouts.frontend')
@section('content')
<div class="content"  >

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.match.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.matches.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                            <h2>Trận {{$match->n_o}}</h2>
                        </div>
                        
                        <div class="container  cal-score-match" >
                                <div class="row justify-content-md-center">
                                    <div class="col-6"> <cal-score :send-score-url="'{{route('admin.matches.sendScore')}}'" :match="{{json_encode( $match)}}" :score-detail="{{ json_encode( $scoreDetail_red ) }}" :match-match-teams1="{{ json_encode($matchMatchTeams_red_1) }}"  :match-match-teams2="{{ json_encode($matchMatchTeams_red_2) }}"  ></cal-score> </div> 
                                    <div class="col-6"> <cal-score :send-score-url="'{{route('admin.matches.sendScore')}}'" :match="{{json_encode( $match)}}" :score-detail="{{ json_encode( $scoreDetail_blue )}}" :match-match-teams1="{{ json_encode($matchMatchTeams_blue_1) }}"  :match-match-teams2="{{ json_encode($matchMatchTeams_blue_2) }}"  ></cal-score> </div>
                                
                                </div>
                             
                        </div>
                 
                        <div class="form-group">
                            <a class="btn btn-primary" href="{{ route('admin.matches.index') }}">
                                 Quay về danh sách trận đấu 
                            </a>
                            <?php if($match->is_finished) { ?>
                                <button class="btn btn-danger" type="button">
                                   Trận đấu đã kết thúc
                               </button>
                                <?php }  else { ?>
                               <form method="POST" action="{{ route("admin.matches.finishedMatch",  $match->id) }}" enctype="multipart/form-data">
                                 @csrf
                           <!-- <a class="btn btn-lg btn-danger" href="{{ route('admin.matches.calculateScore', $match->id) }}">
                                                    Kết thúc trận đấu
                                </a> -->
                                <button class="btn btn-danger" type="submit">
                                    Kết thúc trận đấu
                               </button>
                               <?php } ?>
                        </form>

                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.relatedData') }}
                </div>
                <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
                    <li role="presentation">
                        <a href="#match_score_details" aria-controls="match_score_details" role="tab" data-toggle="tab">
                            {{ trans('cruds.scoreDetail.title') }}
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#match_match_teams" aria-controls="match_match_teams" role="tab" data-toggle="tab">
                            {{ trans('cruds.matchTeam.title') }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" role="tabpanel" id="match_score_details">
                        @includeIf('admin.matches.relationships.matchScoreDetails', ['scoreDetails' => $match->matchScoreDetails])
                    </div>
                    <div class="tab-pane" role="tabpanel" id="match_match_teams">
                        @includeIf('admin.matches.relationships.matchMatchTeams', ['matchTeams' => $match->matchMatchTeams])
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection