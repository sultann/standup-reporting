<div class="panel panel-default">
    <div class="panel-heading">Standup absentee</div>
        <div class="panel-body">
            {!! Form::open(array('url' => 'report/absentee', 'id'=>'absentee-form')) !!}
                <div class="form-group">
                    <label for="" >Mark the person(s)</label >
                    @foreach($teams as $team)
                        @foreach($team->members as $user)
                            @if($user->id !== Auth::user()->id)
                            <div class="checkbox"> <label>
                                    <input <?php echo in_array($user->id, $absentees) ? 'checked': '' ; ?>  type="checkbox" name="absentee[]" value="{{$user->id}}" > {{$user->name}}</label></div>
                            @endif
                        @endforeach
                    @endforeach

                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" >
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>