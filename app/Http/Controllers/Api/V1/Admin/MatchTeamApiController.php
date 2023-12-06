<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMatchTeamRequest;
use App\Http\Requests\UpdateMatchTeamRequest;
use App\Http\Resources\Admin\MatchTeamResource;
use App\Models\MatchTeam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MatchTeamApiController extends Controller
{
    public function index()
    {
    //    abort_if(Gate::denies('match_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $matchTeams = MatchTeam::with(['match', 'team'])->get();
        $matchTeams->load("match");
        return new MatchTeamResource($matchTeams);
    }

    public function store(StoreMatchTeamRequest $request)
    {
        $matchTeam = MatchTeam::create($request->all());

        return (new MatchTeamResource($matchTeam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MatchTeam $matchTeam)
    {
       // abort_if(Gate::denies('match_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MatchTeamResource($matchTeam->load(['match', 'team']));
    }

    public function update(UpdateMatchTeamRequest $request, MatchTeam $matchTeam)
    {
        $matchTeam->update($request->all());

        return (new MatchTeamResource($matchTeam))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MatchTeam $matchTeam)
    {
      //  abort_if(Gate::denies('match_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $matchTeam->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
