@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#open-blockers"  role="tab" data-toggle="tab">Open</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="open-blockers">

                    <table class="table table-hover">
                        <thead> <tr> <th style="width: 50px;">#</th> <th style="width: 250px;">Name</th> <th>Blocker</th> <th style="width: 200px;">Date Opened</th> </tr> </thead>
                        <tbody>
                        {{--{{dd($blockers)}}--}}
                        @foreach($blockers as $blocker)
                            <tr>
                                <th scope="row">{{$blocker->id}}</th>
                                <td>{{$blocker->user->name}}</td>
                                <td><a href="/blocker/{{$blocker->id}}" >{{$blocker->blocker}}</a ></td>
                                <td>{{$blocker->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="center-block"> {{$blockers->links()}}</div>
                </div>
                </div>
                </div>
            </div>
        </div>
     </div>
@endsection