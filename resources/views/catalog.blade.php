@extends('layouts.default')

@section('title', 'Catalogue')

@section('bodyclass', 'catalog ' . $bodyclass)

@section('content')

    <h1>{{$title}}</h1>
    <nav class="section-nav">
        @foreach($catalog_menu as $item)
            <a class="section-nav__{{$item->link}} {{Request::segment(1) == $item->link ? 'active' : ''}}" href="{{url($item->link)}}">{{$item->name}}<br></a>
        @endforeach
    </nav>
    
    @include('partials.' . $partial)

@stop
