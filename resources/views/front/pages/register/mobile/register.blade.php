<div class="register">

    <div class="register-form">

        <form id="register-form" method="POST" action="{{route('front_login_register')}}">

            {{ csrf_field() }}

            <div class="one-column">
                <div class="form-group">
                    <div class="form-label">
                        <label for="business" class="label-highlight">Nombre del proyecto</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="business" value="" class="input-highlight"  />
                    </div>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <div class="form-label">
                        <label for="name" class="label-highlight">Nombre del usuario</label>
                    </div>
                    <div class="form-input">
                        <input type="text" name="name" value="" class="input-highlight"  />
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="email" class="label-highlight">Email del usuario</label>
                    </div>
                    <div class="form-input">
                        <input type="email" name="email" value="" class="input-highlight"  />
                    </div>
                </div>
            </div>

            <div class="two-columns">
                <div class="form-group">
                    <div class="form-label">
                        <label for="password" class="label-highlight">Contraseña</label>
                    </div>
                    <div class="form-input">
                        <input type="password" name="password" value="" class="input-highlight"  />
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label for="password_confirmation" class="label-highlight">Confirma la contraseña</label>
                    </div>
                    <div class="form-input">
                        <input type="password" name="password_confirmation" value="" class="input-highlight"  />
                    </div>
                </div>
            </div>

            <div class="form-group login-submit">
                <button type="submit">
                    @lang('front/login.register')
                </button>
            </div>
        </form>

        <div class="login-errors">
            @include('front.components.desktop.form_errors')
        </div>    
    </div>
    
</div>
