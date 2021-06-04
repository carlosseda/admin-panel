@foreach ($faqs as $faq)
    <div class="faq" data-content="{{$loop->iteration}}">
        <div class="faq-title-container">
            <div class="faq-title">
                <h3>{{isset($faq->seo->title) ? $faq->seo->title : ""}}</h3>
            </div>

            <div class="faq-plus-button" data-button="{{$loop->iteration}}"></div>
        </div>
        <div class="faq-description">
            <div class="faq-description-text">
                {!!isset($faq->locale['description']) ? $faq->locale['description'] : "" !!}
            </div>

            @isset($faq->image_featured_desktop->path)
                <div class="faq-description-image">
                    <img src="{{Storage::url($faq->image_featured_mobile->path)}}" alt="{{$faq->image_featured_mobile->alt}}"  title="{{$faq->image_featured_mobile->title}}"/>
                </div>
            @endif
        </div>
    </div>
@endforeach
