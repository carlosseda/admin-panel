<div class="onoffswitch">
    <input type="checkbox" name="active" value="true" {{ old('_token') ? old('activo') : $item->active ? 'checked' : '' }} class="onoffswitch-checkbox" id="myonoffswitch">
    <label class="onoffswitch-label" for="myonoffswitch">
        <span class="onoffswitch-inner"></span>
        <span class="onoffswitch-switch"></span>
    </label>
</div>