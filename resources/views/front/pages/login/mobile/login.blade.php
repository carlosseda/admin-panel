<div class="login">

    <div class="login-form">

        <div class="login-logo">
            @isset($logo->path)
                <a href="/"><img src="{{Storage::url($logo->path)}}" alt="{{$logo->alt}}" title="{{$logo->title}}"></a>
            @endisset
        </div>

        @include('front.components.mobile.login_form')

        <div class="login-errors">
            @include('front.components.desktop.form_errors')
        </div>    
    </div>

</div>