@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
            {{--{{dd($profile_data)}}--}}
                <img src="/images/avatar.png" alt="" class="img-responsive">
            </div>
            <div class="col-md-6 col-md-offset-1">
                    {!! Form::open(array('url' => 'profile/update')) !!}
                <div class="form-group">
                    <label for="">Name:</label>
                    <input type="text" class="form-control" name="name" value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="">Team(s):</label>
                    @if(in_array(14, $user_teams, true))
                        Yes
                    @else
                        No
                    @endif
                    <select name="teams[]" id="" class="form-control team-selection" multiple>
                    @foreach($teams as $team)
                            <option value="{{$team->id}}" {{in_array($team->id, $user_teams, true)? 'selected': false}}>{{$team->team_name}}</option>
                    @endforeach
                        </select>

                    <p>Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.</p>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
