@extends('layouts.template')

@section('content')
    <div class="content-holder clearfix grey-form">
        <div class="container">
            <div class="data-form">
                <h2>Get confirmation link</h2>
                <form action="{{ route('send-confirmation-email', $user) }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $user->email }}" name="email">
                    <button  type="submit" class="btn-link">Send</button>
                </form>
            </div>
        </div>
    </div>
@endsection