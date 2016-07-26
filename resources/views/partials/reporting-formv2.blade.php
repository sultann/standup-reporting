<div class="panel panel-default">
    <div class="panel-heading">Update Your StandUp Report</div>
    <div class="panel-body">
        {!! Form::open(array('url' => 'report/store', 'id'=>'reporting-form')) !!}

        @if((count($last_report)>0) && ($last_report[0]->updated_at->format('d') == $last_report[0]->created_at->format('d')))
            <div class="form-group">
                {!! Form::label('task_done_last_day', 'What you did last day?') !!}
                {!! Form::textarea('task_done_last_day', isset($last_report[0]->task_done)?$last_report[0]->task_done:null, ['class' => 'form-control', 'cols' => '30', 'rows' => '5','required']) !!}
            </div>
        @endif


        <div class="form-group">
            {!! Form::label('task_done', 'What you will do today?') !!}
            {!! Form::textarea('task_done', isset($todays_report->task_done)?$todays_report->task_done:null, ['class' => 'form-control', 'cols' => '30', 'rows' => '5', 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('blocker', 'Any Blocker?') !!}
            {!!
            Form::select('add_blocker', array(
           'yes' => 'Yes',
           'no' => 'No'
            ),'no', array('class' => 'form-control add-blocker'))
            !!}
        </div>
        <div class="form-group blocker-area">
            {!! Form::label('blocker', 'Blocker') !!}
            {!! Form::textarea('blocker', null, ['class' => 'form-control', 'cols' => '30', 'rows' => '2', 'placeholder' => 'Leave blank if no blocker']) !!}
        </div>


        <div class="form-group">
            {!! Form::submit(isset($todays_report->task_done)?'Update':'Submit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>