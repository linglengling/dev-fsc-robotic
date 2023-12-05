<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSeasonRequest;
use App\Http\Requests\UpdateSeasonRequest;
use App\Http\Resources\Admin\SeasonResource;
use App\Models\Season;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeasonApiController extends Controller
{
    public function index()
    {
//        abort_if(Gate::denies('season_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SeasonResource(Season::all());
    }

    public function store(StoreSeasonRequest $request)
    {
        $season = Season::create($request->all());

        return (new SeasonResource($season))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
    
    public function indexteams(Season $season)
    {
//        abort_if(Gate::denies('season_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return response()->json(['status'=>200,'data'=>$season->seasonMatches]);
       // return new SeasonResource($season);
    }


    public function show(Season $season)
    {
//        abort_if(Gate::denies('season_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $season->load('seasonMatches', 'seasonTeams'); 

        return new SeasonResource($season);
    }

    public function update(UpdateSeasonRequest $request, Season $season)
    {
        $season->update($request->all());

        return (new SeasonResource($season))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Season $season)
    {
//        abort_if(Gate::denies('season_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $season->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
