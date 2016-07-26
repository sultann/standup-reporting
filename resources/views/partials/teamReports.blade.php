@foreach($user_reports->teams as $team)
    <div class="panel panel-default">
        <div class="panel-heading"><b>Today's</b> StandUp Reports of Your Team <b>{{$team->team_name}}</b></div>

        <div class="panel-body">
            {{--@if(count(user_reports_reports>0))--}}
            <table class="table table-condensed table-bordered">
                <thead> <tr><th style="width: 350px;">Name</th> <th>Report</th></tr></thead>

                @foreach($team->members as $member)
                    <tr>
                        <td>{{$member->name}}</td>
                        <td>
                            @if(isset($member->reports->first()['task_done']))
                            {!! $member->reports->first()['task_done'] !!}
                        @else

                                X
                        @endif
                                @if(isset($member->reports->first()['absent']))
                                    <i class="fa fa-user-times pull-right absent-mark" aria-hidden="true" title="Seen absent on scrum meeting"></i>
                                @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

@endforeach