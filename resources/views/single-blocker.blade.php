@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            {{--{{dd($blocker)}}--}}
            <div class="col-md-8">
                <div class="panel {{$blocker->status==1? 'panel-danger': 'panel-success'}}">
                    <div class="panel-heading">Panel heading without title</div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection