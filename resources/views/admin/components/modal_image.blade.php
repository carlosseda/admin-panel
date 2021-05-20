<div id="upload-image-modal" class="modal">
    <div class="modal-image">
        <img id="modal-image-original">
    </div>

    <div class="modal-image-attributes">

        <form class="image-form" id="image-form" action="{{route('store_image_seo')}}" autocomplete="off">             

            {{ csrf_field() }}

            <input id="modal-image-temporal-id" type="hidden" name="temporalId" class="input-highlight"  /> 
            <input id="modal-image-entity-id" type="hidden" name="entityId" class="input-highlight"  />                              
            <input id="modal-image-entity" type="hidden" name="entity" class="input-highlight"  />                              
            <input id="modal-image-content" type="hidden" name="content" class="input-highlight"  />                              
            <input id="modal-image-filename" type="hidden" name="filename" class="input-highlight"  />                              
            <input id="modal-image-language" type="hidden" name="language" class="input-highlight"  />                                                           

            <div class="one-column">
                <div class="form-group">
                    <div class="form-label">
                        <label for="category_id" class="label-highlight">
                            Título
                        </label>
                    </div>
                    <div class="form-input">
                        <input id="modal-image-title" type="text" name="title" class="input-highlight"  />                 
                    </div>
                </div>
            </div>

            <div class="one-column">
                <div class="form-group">
                    <div class="form-label">
                        <label for="category_id" class="label-highlight">
                            Alt
                        </label>
                    </div>
                    <div class="form-input">
                        <input id="modal-image-alt" type="text" name="alt" class="input-highlight"  />                 
                    </div>
                </div>
            </div>

        </form>

        <div class="form-button modal-image-store-button" id="modal-image-store-button"> 
            <svg viewBox="0 0 24 24">
                <path d="M0 0h24v24H0z" fill="none"/>
                <path class="store-button-icon" d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm-5 16c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-10H5V5h10v4z"/>
            </svg>
        </div>

        <div class="form-button modal-image-delete-button" data-route="{{route('delete_image')}}" id="modal-image-delete-button"> 
            <p>Eliminar imagen</p>
        </div>
    </div>
</diV>