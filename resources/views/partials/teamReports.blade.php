@foreach($user_reports->teams as $team)
    <div class="panel panel-default">
        <div class="panel-heading"><b>Today's</b> StandUp Reports of Your Team <b>{{$team->team_name}}</b></div>

        <div class="panel-body">
            {{--@if(count(user_reports_reports>0))--}}
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