@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
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

                    </div>
                </nav>
                @if(\Carbon\Carbon::parse($date)->format('d') !== \Carbon\Carbon::today()->format('d'))
                    <div class="alert alert-success" role="alert">
                        <p>Showing Filtered Reports of the day <b>{{\Carbon\Carbon::parse($date)->format('l jS F, Y')}}</b></p>
                        <p><a  target="_blank" href="/generate-report/{{$date}}">Generate Report for the day of {{\Carbon\Carbon::parse($date)->format('l jS F, Y')}}</a></p>
                    </div>
                @endif
                <div class="panel panel-default">
                    <div class="panel-heading">Stand Up Report</div>

                    <div class="panel-body">
                        <table class="table table-striped">
                            @foreach($teams as $team)
                            <tr>
                                <th class="table-header"><a href="report/team/{{$team->id}}">{{$team->team_name}}</a></th>

                                <td>
                                    <table class="table table-bordered inside-table">
                                        <th class="person-name">Name</th>
                                        <th class="person-task">Task</th>
                                        @foreach($team->members as $member)
                                            <tr>
                                                <td class="person-name"><a href="report/user/{{$member->id}}">{{$member->name}}</a></td>
                                                <td class="person-task">   @if(isset($member->reports[0]))
                                                        {!! $member->reports[0]->task_done !!}
                                                    @else
                                                        X
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                   @endforeach

                        </table>
                    </div>
                </div>
                </div>
            <div class="col-md-4">
            @include('partials.not-reported-list')
            @include('partials.blocker-list')
            @include('partials.reporting-form')


            </div>
        </div>
    </div>
    </div>
@endsection
