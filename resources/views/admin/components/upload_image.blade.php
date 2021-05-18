@if($type == "image" )
    @foreach ($files as $image)
        @if($image->language == $alias)
            <div class="upload-image single {{$image->id}}" data-url="{{route('show_image_seo', ['image' => $image->id])}}">
                
                <div class="upload-image-options">
                    <svg viewBox="0 0 24 24">
                        <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z" />
                    </svg>
                </div>

                <div class="upload-image-thumb" style="background-image: url({{Storage::url($image->path)}})"></div>
            </div>
        @endif
    @endforeach

    <div class="upload-image-add single">
        <span class="upload-image-prompt">@lang('admin/image.image-drop')</span>
        <input class="upload-image-input" type="file" name="images[{{$content}}.{{$alias}}]">
    </div>
@endif

@if($type == "images")

    <div class="upload-image-collection">      

        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="upload-image collection {{$image->id}}" data-url="{{route('show_image_seo', ['image' => $image->id])}}">
                    <div class="upload-image-options">
                        <svg viewBox="0 0 24 24">
                            <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z" />
                        </svg>
                    </div>
           
                    <div class="upload-image-thumb" style="background-image: url({{Storage::url($image->path)}})"></div>
                </div>
            @endif
        @endforeach

        <div class="upload-image-add collection" data-content="{{$content}}" data-alias="{{$alias}}">      
            <span class="upload-image-prompt">+</span>
            <input class="upload-image-input" type="file">
        </div>
    </div>

@endif