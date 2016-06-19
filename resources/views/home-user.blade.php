@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('partials.reporting-form')
                @include('partials/teamReports')
                @include('partials/user-current-month-report')
            </div>
            <div class="col-md-4">
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
                                         <span class="label success-class label-success">Resolved</span>
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

@endsection
