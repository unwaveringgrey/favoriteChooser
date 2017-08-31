@extends('layouts.app')

@section('content')
    <div class="container">
        <form role="form" method="POST" action="{{ route('favorite_select') }}">
            {{ csrf_field() }}
            <h1>Random Favorite:</h1>
            {{$favorite->name}}
        </form>
    </div>
@endsection