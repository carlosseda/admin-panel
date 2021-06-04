@foreach ($faqs as $faq)
    <div class="faq" data-content="{{$loop->iteration}}">
        <div class="faq-title-container">
            <div class="faq-title">
                <h3>{{isset($faq->seo->title) ? $faq->seo->title : ""}}</h3>
            </div>

            <div class="faq-plus">
                <div class="faq-plus-button" data-button="{{$loop->iteration}}"></div>
            </div>
        </div>
        <div class="faq-description">
            <div class="faq-description-text {{isset($faq->image_featured_desktop->path) ? 'with-image':''}}">
                {!!isset($faq->locale['description']) ? $faq->locale['description'] : "" !!}
            </div>

            @isset($faq->image_featured_desktop->path)

                <div class="faq-description-image">
                    <div class="faq-description-image-featured">
                        <img src="{{Storage::url($faq->image_featured_desktop->path)}}" alt="{{$faq->image_featured_desktop->alt}}" title="{{$faq->image_featured_desktop->title}}" />
                    </div>
                </div>  
            @endif
            
        </div>
    </div>
@endforeach