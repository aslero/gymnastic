@extends('layouts.app-form')

@section('content')
    <div class="container">
        <div class="content-form_sidebar two">
            <div class="header-add_form">
                <p class="header--title">Что Вы хотите добавить?</p>
                <nav class="nav-category--header">
                    <a href="" class="active">новость</a>
                    <a href="">объявление</a>
                    <a href="">мероприятие</a>
                    <a href="">участника</a>
                    <a href="">музыку</a>
                </nav>
            </div>
            <h1 class="add">форма добавления новости</h1>
            <add-article></add-article>
        </div>
    </div>
@endsection
