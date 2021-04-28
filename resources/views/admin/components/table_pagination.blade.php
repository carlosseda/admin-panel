@if($agent->isDesktop())
    <div class="table-pagination">
        <div class="table-pagination-info">
            <div class="table-pagination-total"><p>{{$items->total()}} registros</p></div>
            <div class="table-pagination-pages"><p>Mostrando la página {{$items->currentPage()}} de {{$items->lastPage()}}</p></div>
        </div>
        <div class="table-pagination-buttons">
            <p>
                <span class="table-pagination-button" data-pagination="{{$items->url(1)}}">Primera</span>
                <span class="table-pagination-button" data-pagination="{{$items->previousPageUrl()}}">Anterior</span>
                <span class="table-pagination-button" data-pagination="{{$items->nextPageUrl()}}">Siguiente</span>
                <span class="table-pagination-button" data-pagination="{{$items->url($items->lastPage())}}">Última</span>
            </p>
        </div>
    </div>
@endif

@if($agent->isMobile())
    <div class="pagination" data-pagination="{{$items->nextPageUrl()}}" data-lastpage="{{$items->lastPage()}}">
    </div>
@endif