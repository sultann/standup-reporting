@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                @if(\Carbon\Carbon::parse($date)->format('d') !== \Carbon\Carbon::today()->format('d'))
                    <div class="alert alert-success" role="alert">Showing Filtered Reports of the day <b>{{\Carbon\Carbon::parse($date)->format('l jS F, Y')}}</b></div>
                @endif
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand filter-title" href="#">
                                Filter By Date
                            </a>
                        </div>
                        {!! Form::open(array('url' => '/', 'class' => 'navbar-form navbar-left pull-right')) !!}
                        <div class="form-group">
                            <input type="text" name="dateFilter" id="select-date-filter" class="form-control" placeholder="Select Date">
                        </div>
                        <div class="form-group">
                            {!! Form::submit('Submit', ['class' => 'btn btn-default', 'id' => '']) !!}
                        </div>
                        {!! Form::close() !!}


                        {{--<form class="navbar-form navbar-left pull-right" role="search" method="POST" action="report/filter-report">--}}
                            {{--<div class="form-group">--}}
                                {{--<input type="text" name="date-filter" id="select-date-filter" class="form-control" placeholder="Select Date">--}}
                            {{--</div>--}}
                            {{--<button type="submit" class="btn btn-default">Submit</button>--}}
                        {{--</form>--}}
                    </div>
                </nav>
                @foreach($teams as $team)
                    <div class="panel panel-default team-reports">
                        <div class="panel-heading"><b>Today's</b> StandUp Reports of <b> <a href="report/team/{{$team->id}}">{{$team->team_name}}</a></b></div>

                        <div class="panel-body">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th style="width: 33%;">Name</th>
                                    <th style="width: 33%;">Report</th>
                                </tr>
                                </thead>
                                {{--{{dd($reports)}}--}}
                                @foreach($team->members as $member)
                                    <tr>
                                        <td>
                                            <a href="report/user/{{$member->id}}">{{$member->name}}</a>
                                        </td>
                                        <td>
                                            @if(isset($member->reports[0]))
                                                {{$member->reports[0]->task_done}}
                                            @else
                                                X
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </table>

                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-5">
                <div class="widget">
                    <div class="panel panel-default">
                        <div class="panel-heading">Not Reported Yet ({{count($late_parties)}})</div>
                        <div class="panel-body">
                            <ul>
                                {{--{{dd($late_parties)}}--}}
                                @foreach($late_parties as $late_party)
                                    <li>{{$late_party->name}}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="panel panel-default blockers">
                        <div class="panel-heading">Blockers ({{count($blockers)}})</div>

                        <div class="panel-body">
                            <ul class="blockers admin-blockers">
                                @foreach($blockers as $blocker)
                                    <li class="blocker-item">
                                        <div class="blocker">
                                            {{$blocker->blocker}}
                                        </div>
                                        <div class="blocker-meta">
                                            <span class="blocker-submitted">
                                            {{$blocker->user->name}}
                                            </span>
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
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
