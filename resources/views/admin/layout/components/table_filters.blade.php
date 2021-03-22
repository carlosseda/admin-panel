<div class="filters-container">

    <div class="filters-container-first-group">
        <div class="search-container">
            <div class="search-button-container">
                <svg xmlns="http://www.w3.org/2000/svg" class="filter-button search-button" viewBox="0 0 24 24">
                    <path class="search-button-icon" d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
                    <path d="M0 0h24v24H0z" fill="none"/>
                </svg>
            </div>
            
            <div class="search-input-container">
                <input type="text" class="search" value="">
            </div>
        </div>
    </div>
    
    <div class="filters-container-second-group">
        <div class="filter-buttons">
            @isset($order_route)
                <svg xmlns="http://www.w3.org/2000/svg" class="filter-button order-button" route="{{route($order_route)}}" viewBox="0 0 24 24">
                    <path class="order-button-icon" d="M14 5h8v2h-8zm0 5.5h8v2h-8zm0 5.5h8v2h-8zM2 11.5C2 15.08 4.92 18 8.5 18H9v2l3-3-3-3v2h-.5C6.02 16 4 13.98 4 11.5S6.02 7 8.5 7H12V5H8.5C4.92 5 2 7.92 2 11.5z"/>
                    <path fill="none" d="M0 0h24v24H0z"/>
                </svg>
            @endif
    
            @isset($date_filter)
                <svg xmlns="http://www.w3.org/2000/svg" class="filter-button daterange-button" viewBox="0 0 24 24">
                    <path class="daterange-button-icon" d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                    <path fill="none" d="M0 0h24v24H0z"/>
                </svg>
            @endisset

            @isset($import)
                <svg viewBox="0 0 24 24" class="filter-button import-button"  route="{{route($import)}}">
                    <path d="M17.65,6.35C16.2,4.9 14.21,4 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20C15.73,20 18.84,17.45 19.73,14H17.65C16.83,16.33 14.61,18 12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6C13.66,6 15.14,6.69 16.22,7.78L13,11H20V4L17.65,6.35Z" />
                </svg>
            @endif

            @isset($ping)
                <svg style="width:2em;height:2em;margin-top: 0.25em;" viewBox="0 0 24 24" class="filter-button google-button" data-route="{{route($ping)}}">
                    <path d="M21.35,11.1H12.18V13.83H18.69C18.36,17.64 15.19,19.27 12.19,19.27C8.36,19.27 5,16.25 5,12C5,7.9 8.2,4.73 12.2,4.73C15.29,4.73 17.1,6.7 17.1,6.7L19,4.72C19,4.72 16.56,2 12.1,2C6.42,2 2.03,6.8 2.03,12C2.03,17.05 6.16,22 12.25,22C17.6,22 21.5,18.33 21.5,12.91C21.5,11.76 21.35,11.1 21.35,11.1V11.1Z" />
                </svg>
            @endif   
        </div>

        @isset($subfilter)
            <div class="subfilter-select-container"> 
                <select 
                    id="subfilter" 
                    class="filter-select form-control primary-select-related">
                        <option name="todas">Todas</option>
                        @foreach($subfilter as $subfilter_input)
                            <option value="{{$subfilter_input->id}}" name='{{$subfilter_input->name}}'>{{$subfilter_input->name}}</option>
                        @endforeach
                </select>
            </div>
        @endisset     
        
    </div>

</div>