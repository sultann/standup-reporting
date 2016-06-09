@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail Stand Up Reports of <b>{{$user->name}}</b></div>

                        <div class="panel-body">
                            @if(count($user_reports)>0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="person-name">Date</th>
                                    <th class="person-task">Report</th>
                                </tr>
                                </thead>
                                @foreach($user_reports as $report)
                                    <tr>
                                        <td class="v-middle text-center">
                                            {{$report->created_at->format('l jS F, Y')}}
                                        </td>
                                        <td class="v-middle">
                                            {{$report->task_done}}
                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                                <div class="center-block"> {{$user_reports->links()}}</div>
                            @else
                                <p>No Report found for the user</p>
                            @endif



                        </div>
                    </div>
            </div>
            <div class="col-md-4">
                <div class="widget">
                    <div class="panel panel-default">
                        <div class="panel-heading">User Details</div>
                        <div class="panel-body">

                            <dl class="dl-horizontal">
                                <dt>Name</dt>
                                <dd><i class="fa fa-user" aria-hidden="true"></i> {{$user->name}}</dd>
                                <dt>Associated with</dt>
                                @foreach($user_teams as $team)
                                <dd><i class="fa fa-check" aria-hidden="true"></i> {{$team->team_name}}</dd>
                                 @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="panel panel-default blockers">
                        <div class="panel-heading">Blockers Opened by the User</div>

                        <div class="panel-body">
                            @if(count($user_blockers)>0)
                                <ol class="blockers admin-blockers">
                                @foreach($user_blockers as $blocker)
                                <li class="blocker-item">
                                <div class="blocker">
                                {{$blocker->blocker}}
                                </div>
                                <div class="blocker-meta">
                                <span class="opened">
                                {{$blocker->created_at}}
                                </span>
                                <span class="blocker-status">
                                @if($blocker->status == 1)
                                <span class="label label-danger">Open</span>
                                <span><a href="/blocker/{{$blocker->id}}/resolve"><i
                                class="fa fa-check-circle"
                                aria-hidden="true"></i></a></span>
                                @else
                                <span class="label label-success">Resolved</span>
                                @endif
                                </span>

                                </div>
                                </li>
                                @endforeach
                                </ol>
                            @else
                                <b>No blocker found for the user</b>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
