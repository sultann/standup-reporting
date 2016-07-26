@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            {{--{{dd($blocker)}}--}}
            <div class="col-md-8">
                <div class="panel panel-default clearfix" style="margin-bottom: 100px;">
                    <div class="panel-body">
                        <p style="font-size: 18px;font-weight: 400">{{$blocker->blocker}}</p>
                    </div>
                    <div class="panel-footer" style="overflow: auto;">
                        <span class="pull-left">Opened by: <i>{{$blocker->user->name}}</i></span>
                        <span class="pull-right">Opened at: <i>{{$blocker->created_at->format('l jS F, Y')}} ({{ \Carbon\Carbon::createFromTimeStamp(strtotime($blocker->created_at))->diffForHumans()}})</i></span>
                    </div>
                </div>
                {{--<div style="margin: 20px 0 70px 0;">--}}
                    {{--<p><strong>{{$blocker->blocker}}</strong></p>--}}

                    {{--<address>--}}
                        {{--<b>Opened by:</b> {{$blocker->user->name}}--}}
                        {{--<b>Opened by:</b> {{$blocker->created_at}}--}}
                    {{--</address>--}}


                {{--</div>--}}
                <hr >
                @if(count($comments)>0)
                    @foreach($comments as $comment)
                        <div class="row">
                            <div class="col-sm-2">
                                <div class="thumbnail">
                                    <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                                </div><!-- /thumbnail -->
                            </div><!-- /col-sm-1 -->

                            <div class="col-sm-10">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <strong>{{$comment->user->name}}</strong> <span class="text-muted">commented {{ \Carbon\Carbon::createFromTimeStamp(strtotime($comment->created_at))->diffForHumans()}}</span>
                                    </div>
                                    <div class="panel-body">
                                       {{$comment->comment}}
                                    </div><!-- /panel-body -->
                                </div><!-- /panel panel-default -->
                            </div><!-- /col-sm-5 -->

                        </div>
                    @endforeach
                @endif

                @if($blocker->status == 1)
                    <div class="row">
                        <div class="col-md-12">
                            <a type="button" class="btn btn-success" href="/blocker/resolve/{{$blocker->id}}" style="margin: 30px 0;">Mark as resolved</a>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-12">
                        {!! Form::open(['url' => 'blocker-comment/store']) !!}
                        <div class="form-group">
                            {!!Form::label('comment', 'Comment:') !!}
                            {!!Form::textarea('comment', '',['class' => 'form-control', 'id' => 'comment', 'col' => '30', 'rows' => '4', 'required' => 'required']) !!}
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                        <input type="hidden" name="blocker_id" value="{{$blocker->id}}">
                        {!! Form::close() !!}
                    </div>
                </div>
                @else
                    <div class="alert alert-success" role="alert">
                       The blocker has been marked as resolved.
                    </div>
                @endif
            </div>
            <div class="col-md-4">

            </div>
        </div>
    </div>

@endsection