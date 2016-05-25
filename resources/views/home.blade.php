@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">Your StandUp reports for {{date('M')}}</div>

                    <div class="panel-body">
                        <table class="table table-condensed">
                            <thead> <tr><th style="min-width: 150px;">Date</th> <th>Report</th>  <th>Blocker</th></tr></thead>
                            {{--{{dd($reports)}}--}}
                            @foreach($reports as $report)
                                <tr>
                                    <td>
                                        {{$report->created_at}}
                                    </td>
                                    <td>
                                        {{$report->task_done}}
                                    </td>
                                    <td>
                                        {{$report->blocker}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">Update Your StandUp for today</div>

                    <div class="panel-body">
                        {!! Form::open(array('url' => 'report/update')) !!}
                        <div class="form-group">
                            {!! Form::label('task_done_last_day', 'What you did last day?') !!}
                            {!! Form::textarea('task_done_last_day', 'test', ['class' => 'form-control', 'cols' => '30', 'rows' => '5']) !!}
                        </div>

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
            </div>
        </div>
    </div>
@endsection
