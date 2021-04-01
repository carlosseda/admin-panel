<div class="faqs">

    @foreach ($faqs as $faq)
        <div class="faq" data-content="{{$loop->iteration}}">
            <div class="faq-title-container">

                <div class="faq-title">
                    <h3>{{$faq->title}}</h3>
                </div>

                <div class="faq-plus-button" data-button="{{$loop->iteration}}"></div>
            </div>
            <div class="faq-description">
                <p>{{$faq->description}}</p>
            </div>
        </div>
    @endforeach

</div>
