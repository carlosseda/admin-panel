<div class="forms-buttons">
    
    @isset($route)
        <div class="form-button store-button" id="store-button"> 
            <svg viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path class="store-button-icon" d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
        </div>
    @endisset
    
    @isset($create)
        <div class="form-button create-button" id="create-button" data-url="{{route($route.'_create')}}"> 
            <svg viewBox="0 0 24 24">
                <path class="create-button-icon" d="M19.36,2.72L20.78,4.14L15.06,9.85C16.13,11.39 16.28,13.24 15.38,14.44L9.06,8.12C10.26,7.22 12.11,7.37 13.65,8.44L19.36,2.72M5.93,17.57C3.92,15.56 2.69,13.16 2.35,10.92L7.23,8.83L14.67,16.27L12.58,21.15C10.34,20.81 7.94,19.58 5.93,17.57Z" />
            </svg>
        </div>
    @endisset

    @isset($visible)
        <div class="switch-container">
            <div class="onoffswitch">
                <input type="checkbox" name="visible" value="{{$visible == 1 ? 'true' : 'false'}}" {{$visible == 1 ? 'checked' : '' }} class="onoffswitch-checkbox" id="onoffswitch">
                <label class="onoffswitch-label" for="onoffswitch">
                    <span class="onoffswitch-inner"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </div>
    @endisset
</div>


