<div class="faqs">

    @include('front.components.desktop.faqs', ['faqs' =>$faqs])

    <div class="faqs-message">
        <p>@lang('front/faqs.contact-message')</p>
    </div>

    <div class="faqs-contact">
        <button>
            @lang('front/faqs.contact-button')
        </button>
    </div>
    
</div>
