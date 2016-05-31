@extends('layouts.app')

@section('content')
    {{--{{dd($report_updated)}}--}}
    <div class="container">
        <div class="row">
            <div class="col-md-8">


                @foreach($user->teams as $team)
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Today's</b> StandUp Reports of Your Team <b>{{$team->team_name}}</b></div>

                        <div class="panel-body">
                            {{--@if(count($user_reports>0))--}}
                            <table class="table table-condensed">
                                <thead> <tr><th style="width: 350px;">Name</th> <th>Report</th></tr></thead>

                                @foreach($team->members as $member)
                                <tr>
                                    <td>{{$member->name}}</td>
                                    @if(count($member->reports)>0)
                                        <td>{{$member->reports[0]->task_done}}</td>
                                     @else
                                        <td>X</td>
                                      @endif
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                @endforeach

                <div class="panel panel-default">
                    <div class="panel-heading">Your StandUp Reports for The Month of <b>{{date('M')}}</b></div>

                    <div class="panel-body">
                        <table class="table table-condensed">
                            <thead> <tr><th style="min-width: 150px;">Date</th> <th>Report</th>  <th>Blocker</th></tr></thead>
                            {{--@foreach($user_reports as $report)--}}
                                {{--<tr>--}}
                                    {{--<td>--}}
                                        {{--{{$report->created_at}}--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--{{$report->task_done}}--}}
                                    {{--</td>--}}
                                    {{--<td>--}}
                                        {{--{{$report->blocker}}--}}
                                    {{--</td>--}}
                                {{--</tr>--}}
                            {{--@endforeach--}}
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                @if( $report_updated)
                <div class="alert alert-success" role="alert">
                    <strong>Well done!</strong> <br>You are done for today. Please get back tomorrow again.
                </div>
                @else
                <div class="panel panel-default">
                    <div class="panel-heading">Update Your StandUp for today</div>
                    <div class="panel-body">
                        {!! Form::open(array('url' => 'report/update')) !!}
                        @if($last_report)
                        <div class="form-group">
                            {!! Form::label('task_done_last_day', 'What you did last day?') !!}
                            {!! Form::textarea('task_done_last_day', $last_report->task_done, ['class' => 'form-control', 'cols' => '30', 'rows' => '5']) !!}
                        </div>
                        @endif
                        <div class="form-group">
                            {!! Form::label('task_done', 'What you you will do today?') !!}
                            {!! Form::textarea('task_done', null, ['class' => 'form-control', 'cols' => '30', 'rows' => '5']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('blocker', 'Any Blocker?') !!}
                            {!! Form::textarea('blocker', null, ['class' => 'form-control', 'cols' => '30', 'rows' => '2']) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::submit('Submit', ['class' => 'form-control btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                  @endif
            </div>
        </div>
    </div>



    {{--{{var_export($user_team)}}--}}

@endsection
