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
            {!! Form::label('task_done', 'What you will do today?') !!}
            {!! Form::textarea('task_done', isset($TodaysReport->task_done)?$TodaysReport->task_done:null, ['class' => 'form-control', 'cols' => '30', 'rows' => '5', 'required']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('blocker', 'Any Blocker?') !!}
            {!! Form::textarea('blocker', null, ['class' => 'form-control', 'cols' => '30', 'rows' => '2']) !!}
        </div>


        <div class="form-group">
            {!! Form::submit(isset($TodaysReport->task_done)?'Update':'Submit', ['class' => 'form-control btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>
</div>