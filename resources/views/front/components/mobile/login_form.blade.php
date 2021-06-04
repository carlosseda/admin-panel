<form id="login-form" method="POST" action="{{route('front_login_submit')}}">

    {{ csrf_field() }}

    <div class="form-group">
        <div class="form-label">
            <label for="email" class="label-highlight">Email</label>
        </div>
        <div class="form-input">
            <input type="email" class="input-highlight" value="" name="email">
        </div>
    </div>

    <div class="form-group">
        <div class="form-label">
            <label for="password" class="label-highlight">Contraseña</label>
        </div>
        <div class="form-input">
            <input type="password" class="input-highlight" name="password">
        </div>
    </div>

    <div class="form-group login-submit">
        <button type="submit">
            @lang('front/login.login')
        </button>
    </div>
</form>