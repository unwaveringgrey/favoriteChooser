@extends('layouts.app')

@section('content')
    @if (session('error'))
        <div class="error_box">
            {{ session('error') }}
        </div>
    @endif
    <div class="container">
        <form role="form" name="favorite_chooser" method="POST" action="{{ route('favorite_submit') }}">
            {{ csrf_field() }}
            <h1>Top Voted Favorites:</h1>
            @foreach($top_favorites as $top_favorite)
            <div class="favorite_box">
                {{$top_favorite['data']->name}}<br/>
                Votes: {{$top_favorite['net_votes']}}
                @if(isset($top_favorite['image_url']))
                    <img src="{{$top_favorite['image_url']}}">
                @endif
            </div>
            @endforeach
            <br/>
            <br/>
        </form>
    </div>
    <link href="{{ asset('css/chooser.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('javascript')
@endsection