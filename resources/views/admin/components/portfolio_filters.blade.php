<div class="filters-container">
    <div class="filters-container-first-group">
        <div class="pagination">
            {{ $items->links() }}
        </div>
    </div>
    
    <div class="filters-container-second-group">

        @if($route == 'media')
            <div class="filter-files subfilter-select-container" route="{{route('media_filter')}}">
                <select 
                    data-placeholder="Tipo de archivo"
                    id="filter-files"
                    class="form-control">
                        <option value="todos" name='todos' selected>Todos</option>
                        <option value="imagenes" name='imagenes'>Imágenes</option>
                        <option value="documentos" name='documentos'>Documentos</option>
                </select>             
            </div>
        @endif
    </div>
</div>