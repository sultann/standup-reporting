@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail StandUp Reports for <b>{{$team->team_name}}</b></div>
                        <div class="panel-body">
                            @if(count($team_reports)>0)
                                <?php $date = 'test'; ?>
                                <table class="table table-bordered table-striped">
                                    @foreach($team_reports as $report)
                                        @if($date != $report->created_at->format('d'))
                                            {{--{{$date}}--}}
                                        <tr>
                                            <th colspan="3" class="person-name">{{$report->created_at->format('l jS F, Y')}}</th>
                                        </tr>
                                        {{--<tr>--}}
                                            {{--<th class="person-name">Name</th>--}}
                                            {{--<th class="person-task">Task</th>--}}
                                        {{--</tr>--}}

                                        @endif
                                        <tr>
                                            <td class="person-name"><a href="/report/user/{{$report->user->id}}">{{$report->user->name}}</a></td>
                                            <td class="person-task">
                                             {!! $report->task_done !!}
                                                @if($report->absent == 1)
                                                    <i class="fa fa-user-times pull-right absent-mark" aria-hidden="true" title="Seen absent on scrum meeting"></i>
                                                @endif
                                            </td>
                                        </tr>
                                            <?php $date = $report->created_at->format('d'); ?>
                                        @endforeach
                                </table>
                                {{$team_reports->links()}}
                            @else
                                <p>No Report found for the user</p>
                            @endif



                        </div>
                    </div>
            </div>
            <div class="col-md-4">
                <div class="widget">
                    <div class="panel panel-default">
                        <div class="panel-heading">Team Details</div>
                        <div class="panel-body">

                            <dl>
                                <dt>Name:</dt>
                                <dd style="padding-left: 20px;margin-bottom:10px; ">{{$team->team_name}}</dd>
                                <dt>Team Members:</dt>
                                @foreach($team_members as $member)
                                <dd style="padding-left: 20px;"><i class="fa fa-user" aria-hidden="true"></i>  {{$member->name}}</dd>
                                 @endforeach
                            </dl>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
