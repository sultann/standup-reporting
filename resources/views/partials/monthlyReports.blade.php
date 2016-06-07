<div class="panel panel-default">
    <div class="panel-heading">Your StandUp Reports for The Month of <b>{{date('M')}}</b></div>

    <div class="panel-body">
        <table class="table table-condensed">
            <thead> <tr><th style="min-width: 150px;">Date</th> <th>Report</th></tr></thead>
            @foreach($user_reports->reports as $report)
                <tr>
                    <td>
                        {{$report->created_at->format('Y-m-d')}}
                    </td>
                    <td>
                        {{$report->task_done}}
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
</div>