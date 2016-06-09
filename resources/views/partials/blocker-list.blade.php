<div class="widget">
    <div class="panel panel-default blockers">
        <div class="panel-heading">Blockers ({{count($blockers)}})</div>

        <div class="panel-body">

            <ul class="blockers admin-blockers">
                @foreach($blockers as $blocker)
                    <li class="blocker-item">
                        <div class="blocker">
                            {{$blocker->blocker}}
                        </div>
                        <div class="blocker-meta">
                                            <span class="blocker-submitted">
                                            {{$blocker->user->name}}
                                            </span>
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
            </ul>

            {{--<div>--}}
                {{--<!-- Nav tabs -->--}}
                {{--<ul class="nav nav-tabs" role="tablist">--}}
                    {{--<li role="presentation" class="active"><a href="#open-blockers"  role="tab" data-toggle="tab">Open</a></li>--}}
                    {{--<li role="presentation"><a href="#resolved-blockers" role="tab" data-toggle="tab">Resolved</a></li>--}}
                {{--</ul>--}}

                {{--<!-- Tab panes -->--}}
                {{--<div class="tab-content">--}}
                    {{--<div role="tabpanel" class="tab-pane active" id="open-blockers">--}}
                    {{--</div>--}}
                    {{--<div role="tabpanel" class="tab-pane" id="resolved-blockers">...</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
</div>