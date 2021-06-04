<div class="error-container {{ $errors->any() ? 'active' : '' }}">
    <ul class="errors">
        @foreach ($errors->all() as $error)
            <li class="error">{{ $error }}</li>
        @endforeach
    </ul>
</div>
