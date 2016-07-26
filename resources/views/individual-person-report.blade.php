@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-heading">Detail Stand Up Reports of <b>{{$user->name}}</b></div>

                        <div class="panel-body">
                            @if(count($user_reports)>0)
                            <table class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="person-name">Date</th>
                                    <th class="person-task">Report</th>
                                </tr>
                                </thead>
                                @foreach($user_reports as $report)
                                    <tr>
                                        <td class="v-middle text-center">
                                            {{$report->created_at->format('l jS F, Y')}}
                                        </td>
                                        <td class="v-middle">
                                           {!! $report->task_done !!}
                                            @if($report->absent == 1)
                                                <i class="fa fa-user-times pull-right absent-mark" aria-hidden="true" title="Seen absent on scrum meeting"></i>
                                                @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </table>
                                <div class="center-block"> {{$user_reports->links()}}</div>
                            @else
                                <p>No Report found for the user</p>
                            @endif



                        </div>
                    </div>
            </div>
            <div class="col-md-3">
                <div class="widget">

                    <div class="panel panel-default">
                        <div class="panel-heading">User Details</div>
                        <div class="panel-body">
                            <div class="thumbnail text-center">
                                @if(!empty($user->avatar_url))
                                    <img src="{{$user->avatar_url}}" alt="..." class="img-responsive">
                                @else
                                    <img src="/images/dummy/avatar.png" alt="..." class="img-responsive">
                                @endif
                                <div class="caption">
                                    <h4>{{$user->name}}</h4>
                                    <ul class="list-inline"> @foreach($user_teams as $team)
                                             <li> {{$team->team_name}},</li>
                                        @endforeach
                                    </ul>
                                    @if(Auth::user()->role == 'admin')
                                        {!! Form::open(array('url' => '/profile/update_user', 'id'=>'update-user')) !!}
                                        <div class="form-group">
                                            <label for="" >Role</label >
                                            <select name="role" id=""  class="form-control">
                                                <option value="admin" <?php echo $user->role == 'admin'? 'selected': ''; ?> >Admin</option >
                                                <option value="teamlead" <?php echo $user->role == 'teamlead'? 'selected': ''; ?> >Team Lead</option >
                                                <option value="" <?php echo $user->role == ''? 'selected': ''; ?> >General</option >
                                            </select >
                                        </div>
                                        <div class="form-group">
                                            <label for="" >Delete User</label >
                                            <input type="checkbox" name="user_delete" class="delete-user" >
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" >
                                        </div>
                                        <input type="hidden" value="{{$user->id}}" name="user">
                                  {!! Form::close() !!}
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget">
                    <div class="panel panel-default blockers">
                        <div class="panel-heading">Blockers Opened by the User</div>

                        <div class="panel-body">
                            @if(count($user_blockers)>0)
                                <ol class="blockers admin-blockers">
                                @foreach($user_blockers as $blocker)
                                <li class="blocker-item">
                                <div class="blocker">
                                {{$blocker->blocker}}
                                </div>
                                <div class="blocker-meta">
                                <span class="opened">
                                {{$blocker->created_at}}
                                </span>
                                <span class="blocker-status">
                                @if($blocker->status == 1)
                                <span class="label label-danger">Open</span>
                                <span><a href="/blocker/resolve/{{$blocker->id}}"><i
                                class="fa fa-check-circle"
                                aria-hidden="true"></i></a></span>
                                @else
                                <span class="label label-success">Resolved</span>
                                @endif
                                </span>

                                </div>
                                </li>
                                @endforeach
                                </ol>
                            @else
                                <b>No blocker found for the user</b>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </div>
@endsection
