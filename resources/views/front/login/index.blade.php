@extends('front.layout.master')

@section('content')

<div class="login">

    <div class="login-errors">
        @include('front.components.desktop.errors')
    </div>    

    <div class="login-form">

        <form id="login-form" method="POST" action="{{route('front_login_submit')}}">

            {{ csrf_field() }}

            <div class="form-group">
                <div class="form-label">
                    <label for="email" class="label-highlight">Email</label>
                </div>
                <div class="form-input">
                    <input type="email" class="form-control" value="{{ old('email') }}" name="email">
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="password" class="label-highlight">Contraseña</label>
                </div>
                <div class="form-input">
                    <input type="password" class="form-control" name="password">
                </div>
            </div>

            <div class="form-group login-submit">
                <button type="submit">
                    @lang('front/checkout.checkout-continue')
                </button>
            </div>
        </form>
    </div>

   
</div>

@endsection