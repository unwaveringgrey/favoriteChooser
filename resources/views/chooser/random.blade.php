@extends('layouts.app')

@section('content')
    <div class="container">
        <form role="form" method="POST" action="{{ route('favorite_select') }}">
            {{ csrf_field() }}
            <h1>Random Favorite:</h1>
            <div class="favorite_box">
                {{$favorite->name}}<br/>
                Votes: {{$net_votes}}
            </div>
        </form>
    </div>
        <link href="{{ asset('css/chooser.css') }}" rel="stylesheet" type="text/css"/>
@endsection