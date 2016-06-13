@extends('layouts.app')

@section('content')
    {{--{{dd($report_updated)}}--}}
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('partials/teamReports')
                @include('partials/user-current-month-report')

            </div>
            <div class="col-md-4">

                <div class="panel panel-default">
                    <div class="panel-heading">Update Your StandUp for today</div>
                    <div class="panel-body">
                        {!! Form::open(array('url' => 'report/store')) !!}

                        @if((count($yesterday)>0) && ($yesterday[0]->updated_at->format('d') == $yesterday[0]->created_at->format('d')))
                        <div class="form-group">
                            {!! Form::label('task_done_last_day', 'What you did last day?') !!}
                            {!! Form::textarea('task_done_last_day', isset($yesterday[0]->task_done)?$yesterday[0]->task_done:null, ['class' => 'form-control', 'cols' => '30', 'rows' => '5','required']) !!}
                        </div>
                        @endif


                            <div class="form-group">
                                {!! Form::label('task_done', 'What you you will do today?') !!}
                                {!! Form::textarea('task_done', isset($TodaysReport->task_done)?$TodaysReport->task_done:null, ['class' => 'form-control', 'cols' => '30', 'rows' => '5', 'required']) !!}
                            </div>

                        <div class="form-group">
                            {!! Form::label('blocker', 'Any Blocker?') !!}
                            {!! Form::textarea('blocker', null, ['class' => 'form-control', 'cols' => '30', 'rows' => '2', 'placeholder' =>'Leave empty for no blocker']) !!}
                        </div>


                        <div class="form-group">
                            {!! Form::submit(isset($TodaysReport->task_done)?'Update':'Submit', ['class' => 'form-control btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>

                    <div class="widget">
                        <div class="panel panel-default">
                            <div class="panel-heading">Blockers</div>
                            <div class="panel-body">
                                @if(count($user_reports->blockers)<1)
                                    <p>You have not opened any blocker yet.</p>
                                @endif
                                <ul>
                             @foreach($user_reports->blockers as $blocker)
                                 <li>{{$blocker->blocker}}
                                     @if($blocker->status == 1)
                                         <span class="label label-danger">Open</span>
                                         <span><a href="/blocker/resolve/{{$blocker->id}}"><i
                                                         class="fa fa-check-circle"
                                                         aria-hidden="true"></i></a></span>
                                     @else
                                         <span class="label label-success">Resolved</span>
                                     @endif
                                 </li>
                             @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>



    {{--{{var_export($user_team)}}--}}

@endsection
