<div id="error-container" class="error-container {{ $errors->any() ? 'active' : '' }}">
    <ul id="errors" class="errors">
        @foreach ($errors->all() as $error)
            <li class="error">{{ $error }}</li>
        @endforeach
    </ul>
</div>
