@extends('layouts.app-form')

@section('content')
    <div class="container">
        <div class="auth__register">
            <div class="center--box w-50">
                <div class="form__center panel">
                    <p class="title bold">Вход</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="form-body">
                            <div class="input-two field">
                                <div class="item">
                                    <input id="name" type="text" class=" @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="Логин">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="item">
                                    <input id="email" type="email" class=" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="E-mail">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <input id="fullname" type="text" class="field  @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname') }}" required placeholder="ФИО">
                            @if ($errors->has('fullname'))
                                <span class="help-block">
                                <strong>{{ $errors->first('fullname') }}</strong>
                            </span>
                            @endif
                            @error('fullname')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror

                            <div class="input-two field">
                                <div class="item">
                                    <input id="password" type="password" class=" @error('password') is-invalid @enderror" name="password" required placeholder="Пароль">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="item">
                                    <input id="password-confirm" type="password" name="password_confirmation" required placeholder="Подтвердите пароль">
                                </div>
                            </div>
                            <div class="checkbox-input field">
                                <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">Я принимаю условия <a href="">пользовательского соглашения</a></label>
                            </div>
                            <button type="submit" class="btn-blue">Создать аккаунт</button>
                        </div>
                    </form>
                </div>
                <div class="footer--form">
                    <a href="{{ route('password.request') }}">Забыли пароль?</a>
                    <a href="/login">Войти в аккаунт</a>
                </div>
            </div>
        </div>
    </div>
@endsection