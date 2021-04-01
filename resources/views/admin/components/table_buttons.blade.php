@if(in_array('edit', $crud_permissions) && Auth::guard('web')->user()->canAtLeast(['edit']))
    @canatleast(['edit'])
        <svg viewBox='0 0 24 24'  height='2em' width='2em'  class='table-button table-edit-button' route='{{route($route)}}'>
            <path class='table-button-icon' d='M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z'/>
            <path d='M0 0h24v24H0z' fill='none'/>
        </svg>
    @endcanatleast
@endif

@if(in_array('remove', $crud_permissions))
    @canatleast(['remove'])
        <svg viewBox='0 0 24 24'  height='2em' width='2em'  class='table-button table-remove-button' route='{{route($route)}}'>
            <path fill='none' d='M0 0h24v24H0V0z'/>
            <path class='table-button-icon' d='M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z'/>
            <path fill='none' d='M0 0h24v24H0z'/>
        </svg>
    @endcanatleast
@endif

@if(in_array('view', $crud_permissions) && Auth::guard('web')->user()->canAtLeast(['view']))
    @canatleast(['view'])
        <svg viewBox='0 0 24 24' height='2em' width='2em' class='table-button table-view-button' route='{{route($route)}}'>
            <path d='M0 0h24v24H0z' fill='none'/>
            <path class='table-button-icon' d='M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z'/>
        </svg>
    @endcanatleast
@endif

