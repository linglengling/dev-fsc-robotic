@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.show') }} {{ trans('cruds.team.title') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.teams.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.team.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $team->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.team.fields.season') }}
                                    </th>
                                    <td>
                                        {{ $team->season->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.team.fields.name') }}
                                    </th>
                                    <td>
                                        {{ $team->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.team.fields.score') }}
                                    </th>
                                    <td>
                                        {{ $team->score }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        STT
                                    </th>
                                    <td>
                                        {{ $team->n_order }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.teams.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
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
                        <a href="#team_match_teams" aria-controls="team_match_teams" role="tab" data-toggle="tab">
                            {{ trans('cruds.matchTeam.title') }}
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane" role="tabpanel" id="team_match_teams">
                        @includeIf('admin.teams.relationships.teamMatchTeams', ['matchTeams' => $team->teamMatchTeams])
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection