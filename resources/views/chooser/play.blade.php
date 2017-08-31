@extends('layouts.app')

@section('content')
    <div class="container">
        <form role="form" name="favorite_chooser" method="POST" action="{{ route('favorite_submit') }}">
            {{ csrf_field() }}
            <h1>Select A Favorite:</h1>
                <div class="favorite_box">
                    {{$favorites['first_favorite']->name}}
                    <input type='hidden' name="first_favorite" id="first_favorite" class="favorite_id" value='{{$favorites['first_id']}}'/>
                </div>
                <br/>
                <div class="favorite_box">
                    {{$favorites['second_favorite']->name}}
                    <input type='hidden' name="second_favorite" id="second_favorite" class="favorite_id" value='{{$favorites['second_id']}}'/>
                </div>
                <input type='hidden' name="selected_favorite" id='selected_favorite' value=''>
            <br/>
        </form>
    </div>
    <link href="{{ asset('css/chooser.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('javascript')
    <script type="text/javascript" src="{{ asset('js/chooser.js') }}"></script>'
@endsection