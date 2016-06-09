<div class="widget">
    <div class="panel panel-default">
        <div class="panel-heading">Not Reported Yet ({{count($late_parties)}})</div>
        <div class="panel-body">
            <ul class="late-reported-list">
                {{--{{dd($late_parties)}}--}}
                @foreach($late_parties as $late_party)
                    <li>{{$late_party->name}}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>