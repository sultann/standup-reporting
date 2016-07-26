<div class="panel panel-default">
    <div class="panel-heading">Your StandUp Reports for The Month of <b>{{date('M')}}</b></div>

    <div class="panel-body">
        <table class="table table-condensed table-striped">
            <thead> <tr><th style="min-width: 150px;">Date</th> <th>Report</th></tr></thead>
            @foreach($user_reports->reports as $report)
                <tr>
                    <td class="v-middle person-name">
                        {{$report->created_at->format('l jS F, Y')}}
                    </td>
                    <td>
                        {!! $report->task_done !!}
                        @if(isset($report->absent))
                            <i class="fa fa-user-times pull-right absent-mark" aria-hidden="true" title="Seen absent on scrum meeting"></i>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

    </div>
</div>