@extends('layouts.app')

@section('content')
    <div class="container">
        <form role="form" method="POST" action="{{ route('favorite_select') }}">
            {{ csrf_field() }}
            <h1>Select A Favorite:</h1>
        </form>
    </div>
@endsection