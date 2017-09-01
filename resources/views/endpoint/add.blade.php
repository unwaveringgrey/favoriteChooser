@extends('layouts.app')

@section('content')
    <div class="container">
        <form role="form" name="endpoint_creator" method="POST" action="{{ route('endpoint_submit') }}">
            {{ csrf_field() }}
            <h1>Enter Endpoint Information:</h1>
            <label>*Title: </label><input type='text' name="title" id="title" class="favorite_id" class="endpoint_field" value='{{ old('title') }}'/>
            <br/>
            <label>*URL: </label><input type='text' name="url" id="url" class="favorite_id" class="endpoint_field" value='{{ old('url') }}'/>
            <br/>
            <label>Image URL: </label><input type='text' name="image_url" id='image_url' class="endpoint_field" value='{{ old('image_url') }}'>
            <br/>
            <input type='submit' value="Submit"/>
        </form>
    </div>
    <link href="{{ asset('css/chooser.css') }}" rel="stylesheet" type="text/css"/>
@endsection
@section('javascript')
@endsection