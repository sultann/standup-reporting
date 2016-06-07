@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail StandUp Reports for <b>{{$teamReports->team_name}}</b></div>

                        <div class="panel-body">
                            @if(count($teamReports->reports)>0)
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th style="width: 33%;">Date</th>
                                    <th style="width: 33%;">Report</th>
                                </tr>
                                </thead>
                                {{--{{dd($reports)}}--}}
                                @foreach($reports->reports as $report)
                                    <tr>
                                        <td>
                                            {{$report->created_at->format('l jS F, Y')}}
                                        </td>
                                        <td>
                                            {{$report->task_done}}
                                        </td>

                                    </tr>
                                @endforeach
                                {{--{{dd($reports->links())}}--}}
                            </table>
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
                                <dd>{{$reports->name}}</dd>
                                <dt>Associated with</dt>
                                @foreach($reports->teams as $team)
                                <dd>{{$team->team_name}}</dd>
                                 @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
                {{--<div class="widget">--}}
                    {{--<div class="panel panel-default blockers">--}}
                        {{--<div class="panel-heading">Blockers Opened by the User</div>--}}

                        {{--<div class="panel-body">--}}
                            {{--@if(count($reports->blockers)>0)--}}
                                {{--<ul class="blockers admin-blockers">--}}
                                {{--@foreach($reports->blockers as $blocker)--}}
                                {{--<li class="blocker-item">--}}
                                {{--<div class="blocker">--}}
                                {{--{{$blocker->blocker}}--}}
                                {{--</div>--}}
                                {{--<div class="blocker-meta">--}}
                                {{--<span class="opened">--}}
                                {{--{{$blocker->created_at}}--}}
                                {{--</span>--}}
                                {{--<span class="blocker-status">--}}
                                {{--@if($blocker->status == 1)--}}
                                {{--<span class="label label-danger">Open</span>--}}
                                {{--<span><a href="/blocker/{{$blocker->id}}/resolve"><i--}}
                                {{--class="fa fa-check-circle"--}}
                                {{--aria-hidden="true"></i></a></span>--}}
                                {{--@else--}}
                                {{--<span class="label label-success">Resolved</span>--}}
                                {{--@endif--}}
                                {{--</span>--}}

                                {{--</div>--}}
                                {{--</li>--}}
                                {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--@else--}}
                                {{--<b>No blocker found for the user</b>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

            {{--</div>--}}
        </div>
    </div>
    </div>
@endsection
