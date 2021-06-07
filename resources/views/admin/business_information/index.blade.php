@php
    $route = 'business_information';
@endphp

@extends('admin.layout.form')

@section('form')

    <div class="form-container">

        <form class="admin-form" id="business-information-form" action="{{route("business_information_store")}}" autocomplete="off">
            
            {{ csrf_field() }}

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="group" value="front/information">

            <div class="tabs-container">
                <div class="tabs-container-menu">
                    <ul>
                        <li class="tab-item tab-active" data-tab="content">
                            Contacto
                        </li>  
                        <li class="tab-item" data-tab="logo">
                            Logo
                        </li>
                        <li class="tab-item" data-tab="presentation">
                            Presentación
                        </li>  
                        <li class="tab-item" data-tab="socials">
                            Redes
                        </li>       
                    </ul>
                </div>
                
                <div class="tabs-container-buttons">
                    
                    @include('admin.components.form_buttons', ['route' => $route])

                </div>
            </div>
            
            <div class="tab-panel tab-active" data-tab="content">

                @component('admin.components.locale', ['tab' => 'content'])

                    @foreach ($localizations as $localization)

                        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">

                            <div class="two-columns">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Teléfono 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[telephone.{{$localization->alias}}]" value="{{isset($business["telephone.$localization->alias"]) ? $business["telephone.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>
                    
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Email 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[email.{{$localization->alias}}]" value="{{isset($business["email.$localization->alias"]) ? $business["email.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>
                            </div>
                            
                            <div class="two-columns">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Provincia 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[province.{{$localization->alias}}]" value="{{isset($business["province.$localization->alias"]) ? $business["province.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>
            
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Población 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[poblation.{{$localization->alias}}]" value="{{isset($business["poblation.$localization->alias"]) ? $business["poblation.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>
                            </div>
            
                            <div class="two-columns">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Código Postal 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[postalcode.{{$localization->alias}}]" value="{{isset($business["postalcode.$localization->alias"]) ? $business["postalcode.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>
            
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Dirección 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[adress.{{$localization->alias}}]" value="{{isset($business["adress.$localization->alias"]) ? $business["adress.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>
                            </div>
                            
                            <div class="two-columns">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">Horario</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[schedule.{{$localization->alias}}]" value="{{isset($business["schedule.$localization->alias"]) ? $business["schedule.$localization->alias"] : ''}}" class="input-highlight">
                                    </div>
                                </div>
                            </div>

                        </div>

                    @endforeach
            
                @endcomponent

            </div>

            <div class="tab-panel" data-tab="logo">

                @component('admin.components.locale', ['tab' => 'logo'])

                    @foreach ($localizations as $localization)

                        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="logo" data-localetab="{{$localization->alias}}">
       
                            <div class="two-columns">

                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Logo</label>
                                    </div>
                                    <div class="form-input">
                                        @include('admin.components.upload_image', [
                                            'entity' => 'business-information',
                                            'type' => 'single', 
                                            'content' => 'logo', 
                                            'alias' => $localization->alias,
                                            'files' => $business->images_logo_preview
                                        ])
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Logo Negativo</label>
                                    </div>
                                    <div class="form-input">
                                        @include('admin.components.upload_image', [
                                            'entity' => 'business-information',
                                            'type' => 'single', 
                                            'content' => 'logolight', 
                                            'alias' => $localization->alias,
                                            'files' => $business->images_logolight_preview
                                        ])
                                    </div>
                                </div>

                            </div>

                        </div>

                    @endforeach
            
                @endcomponent

            </div>

            <div class="tab-panel" data-tab="socials">

                @component('admin.components.locale', ['tab' => 'socials'])

                    @foreach ($localizations as $localization)

                        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="socials" data-localetab="{{$localization->alias}}">

                            <div class="four-columns">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Instagram
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[instagram.{{$localization->alias}}]" value="{{isset($business["instagram.$localization->alias"]) ? $business["instagram.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Facebook 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[facebook.{{$localization->alias}}]" value="{{isset($business["facebook.$localization->alias"]) ? $business["facebook.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Twitter 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[twitter.{{$localization->alias}}]" value="{{isset($business["twitter.$localization->alias"]) ? $business["twitter.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Whatsapp
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[whatsapp.{{$localization->alias}}]" value="{{isset($business["whatsapp.$localization->alias"]) ? $business["whatsapp.$localization->alias"] : ''}}"  class="input-highlight"  />              
                                    </div>
                                </div>
                            </div>

                        </div>

                    @endforeach
            
                @endcomponent

            </div>

            <div class="tab-panel" data-tab="presentation">

                @component('admin.components.locale', ['tab' => 'presentation'])

                    @foreach ($localizations as $localization)

                        <div class="locale-tab-panel {{ $loop->first ? 'locale-tab-active':'' }}" data-tab="presentation" data-localetab="{{$localization->alias}}">

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">Eslogan</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="business[slogan.{{$localization->alias}}]" value="{{isset($business["slogan.$localization->alias"]) ? $business["slogan.$localization->alias"] : ''}}" class="input-highlight">
                                    </div>
                                </div>
                            </div>

                            <div class="two-columns">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Nuestra compañía
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <textarea class="ckeditor input-highlight" name="business[ourbusiness.{{$localization->alias}}]">{{isset($business["ourbusiness.$localization->alias"]) ? $business["ourbusiness.$localization->alias"] : ''}}</textarea>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-input">
                                        @include('admin.components.upload_image', [
                                            'entity' => 'business-information',
                                            'type' => 'single', 
                                            'content' => 'ourbusiness', 
                                            'alias' => $localization->alias,
                                            'files' => $business->images_our_business_preview
                                        ])
                                    </div>
                                </div>
                            </div>

                            <div class="two-columns">
                                <div class="form-group">
                                    <div class="form-input">
                                        @include('admin.components.upload_image', [
                                            'entity' => 'business-information',
                                            'type' => 'single', 
                                            'content' => 'ourfleet', 
                                            'alias' => $localization->alias,
                                            'files' => $business->images_our_fleet_preview
                                        ])
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="business" class="label-highlight">
                                            Nuestra flota
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <textarea class="ckeditor input-highlight" name="business[ourfleet.{{$localization->alias}}]">{{isset($business["ourfleet.$localization->alias"]) ? $business["ourfleet.$localization->alias"] : ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
            
                @endcomponent

            </div>


        </form>

    </div>

@endsection


