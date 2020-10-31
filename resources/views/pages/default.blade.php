@extends('layouts.default')

@section('title', $page['title'])

@section('bodyclass', 'static')

@section('content')

    <h1>{{$page['title']}}</h1>

    <div class="content {{$page['slug']}}">
        {!! $page['content'] !!}
    </div>
@stop