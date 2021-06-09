<div class="contact">

    <div class="two-columns">
        <div class="sidebar">
            <div class="contact-socials">

                <div class="contact-socials-title">
                    <h3>@lang('front/contact.contact-socials-title')</h3>
                </div>

                <div class="socials-icons">

                    @if(\Lang::has('front/information.facebook'))
                        <div class="social-icon">
                            <a href="{{trans('front/information.facebook')}}">
                                <svg viewBox="0 0 50 50" style="width:100%">
                                    <path class="st0" d="M26.7,21.1v-2.3c0-0.9,0.6-1.1,1-1.1h2.4v-3.8h-3.4c-3.7,0-4.6,2.8-4.6,4.6V21h-2.2v3.9h2.2v10.9h4.5V24.9h3.1   l0.4-3.9L26.7,21.1L26.7,21.1z"/>
                                </svg>
                                {{-- <svg viewBox="0 0 24 24">
                                    <path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z" />
                                </svg> --}}
                            </a>
                        </div>
                    @endif

                    @if(\Lang::has('front/information.twitter'))
                        <div class="social-icon">
                            <a href="{{trans('front/information.twitter')}}">
                                <svg viewBox="0 0 24 24">
                                    <path d="M22.46,6C21.69,6.35 20.86,6.58 20,6.69C20.88,6.16 21.56,5.32 21.88,4.31C21.05,4.81 20.13,5.16 19.16,5.36C18.37,4.5 17.26,4 16,4C13.65,4 11.73,5.92 11.73,8.29C11.73,8.63 11.77,8.96 11.84,9.27C8.28,9.09 5.11,7.38 3,4.79C2.63,5.42 2.42,6.16 2.42,6.94C2.42,8.43 3.17,9.75 4.33,10.5C3.62,10.5 2.96,10.3 2.38,10C2.38,10 2.38,10 2.38,10.03C2.38,12.11 3.86,13.85 5.82,14.24C5.46,14.34 5.08,14.39 4.69,14.39C4.42,14.39 4.15,14.36 3.89,14.31C4.43,16 6,17.26 7.89,17.29C6.43,18.45 4.58,19.13 2.56,19.13C2.22,19.13 1.88,19.11 1.54,19.07C3.44,20.29 5.7,21 8.12,21C16,21 20.33,14.46 20.33,8.79C20.33,8.6 20.33,8.42 20.32,8.23C21.16,7.63 21.88,6.87 22.46,6Z" />
                                </svg>
                            </a>
                        </div>
                    @endif

                    @if(\Lang::has('front/information.instagram'))
                        <div class="social-icon">
                            <a href="{{trans('front/information.instagram')}}">
                                <svg viewBox="0 0 24 24">
                                    <path d="M7.8,2H16.2C19.4,2 22,4.6 22,7.8V16.2A5.8,5.8 0 0,1 16.2,22H7.8C4.6,22 2,19.4 2,16.2V7.8A5.8,5.8 0 0,1 7.8,2M7.6,4A3.6,3.6 0 0,0 4,7.6V16.4C4,18.39 5.61,20 7.6,20H16.4A3.6,3.6 0 0,0 20,16.4V7.6C20,5.61 18.39,4 16.4,4H7.6M17.25,5.5A1.25,1.25 0 0,1 18.5,6.75A1.25,1.25 0 0,1 17.25,8A1.25,1.25 0 0,1 16,6.75A1.25,1.25 0 0,1 17.25,5.5M12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9Z" />
                                </svg>
                            </a>
                        </div>
                    @endif

                    @if(\Lang::has('front/information.whatsapp'))
                        <div class="social-icon">
                            <a href="https://api.whatsapp.com/send?phone={{trans('front/information.whatsapp')}}">
                                <svg viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z" />
                                </svg>
                            </a>
                        </div>
                    @endif

                </div>
            </div>

            <div class="contact-info">

                <div class="contact-info-title">
                    <h3>@lang('front/contact.contact-info-title')</h3>
                </div>

                @if(\Lang::has('front/information.adress'))
                    <div class="contact-info-element">
                        <div class="contact-info-icon">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5M12,2A7,7 0 0,0 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9A7,7 0 0,0 12,2Z" />
                            </svg>
                        </div>
                        <div class="contact-info-text">
                            <p>@lang('front/information.adress')</p>
                        </div>
                    </div>
                @endif
                
                @if(\Lang::has('front/information.telephone'))
                    <div class="contact-info-element">
                        <div class="contact-info-icon">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z" />
                            </svg>
                        </div>
                        <div class="contact-info-text">
                            <p>@lang('front/information.telephone')</p>
                        </div>
                    </div>
                @endif
                
                @if(\Lang::has('front/information.email'))
                    <div class="contact-info-element">
                        <div class="contact-info-icon">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" />
                            </svg>
                        </div>
                        <div class="contact-info-text">
                            <p>@lang('front/information.email')</p>
                        </div>
                    </div>
                @endif
                
                @if(\Lang::has('front/information.schedule'))
                    <div class="contact-info-element">
                        <div class="contact-info-icon">
                            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z" />
                            </svg>
                        </div>
                        <div class="contact-info-text">
                            <p>@lang('front/information.schedule')</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="main">
            @include('front.components.desktop.contact_form')
        </div>
    </div>

    <div class="one-column">
        <div class="contact-map">
            <div class="contact-map-title">
                <h3>@lang('front/contact.contact-map-title')</h3>
            </div>
            <div class="contact-map-text">
                <p>@lang('front/contact.contact-map-text')</p>
            </div>
            <div class="contact-map-ubication">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3077.156430153422!2d2.7122383153692575!3d39.53352497947753!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x129796a141bfb921%3A0x7d2d887f8bb0fc7d!2sCarrer%20de%20Virgili%2C%2027%2C%2007610%20Palma%2C%20Illes%20Balears!5e0!3m2!1ses!2ses!4v1618557330406!5m2!1ses!2ses" allowfullscreen="" loading="lazy" data-origwidth="600" data-origheight="350"></iframe>
            </div>
        </div>
     

    </div>
    
</div>
