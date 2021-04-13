<div class="faqs">

    @foreach ($faqs as $faq)
        <div class="faq" data-content="{{$loop->iteration}}">
            <div class="faq-title-container">

                <div class="faq-title">
                    {{-- <h3>{{$faq->title}}</h3> --}}
                    <h3>Esto es una prueba de título</h3>
                </div>

                <div class="faq-plus-button" data-button="{{$loop->iteration}}"></div>
            </div>
            <div class="faq-description">
                {{-- <p>{{$faq->description}}</p> --}}
                <p>Esto es una prueba de descripción.</p>
            </div>
        </div>
    @endforeach

</div>
