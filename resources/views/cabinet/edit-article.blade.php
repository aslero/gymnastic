@extends('layouts.app-form')

@section('content')
    <div class="container">
        <div class="content-form_sidebar two">
            <h1 class="add">{{$article->title}}</h1>
            <edit-article :id="{{$article->id}}"></edit-article>
        </div>
    </div>
@endsection