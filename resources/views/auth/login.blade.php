@extends('layouts.app-form')

@section('content')
    <div class="container">
        <div class="auth__register">
            <div class="center--box">
                <div class="form__center panel">
                    <p class="title bold">Вход</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-body">
                            <input id="email" type="email" class="field @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus  placeholder="E-mail">

                            @error('email')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input id="password" type="password" class="field @error('password') is-invalid @enderror" name="password" required  placeholder="Пароль">

                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <div class="checkbox-input field">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Запомнить меня</label>
                            </div>
                            <button type="submit" class="btn-blue">Войти</button>
                        </div>
                    </form>
                </div>
                <div class="footer--form">
                    <a href="{{ route('password.request') }}">Забыли пароль?</a>
                    <a href="/register">Создать новый аккаунт</a>
                </div>
            </div>
        </div>
    </div>
@endsection

