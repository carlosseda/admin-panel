<nav class="menu-container">
    <ul class="menu">
        {{-- @canatleast(['inventory'])
            <li class="menu-item submenu-container"><a>Inventario</a>
                <ul class="submenu">
                    <li class="submenu-item menu-link" data-route="{{route('incidents')}}"><a>Incidencias</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('computers')}}"><a>Ordenadores</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('screens')}}"><a>Pantallas</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('projectors')}}"><a>Proyectores</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('printers')}}"><a>Impresoras</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('3d_printers')}}"><a>3D</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('nets')}}"><a>Redes</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('furnitures')}}"><a>Mobiliario</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('softwares')}}"><a>Software</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('os_sessions')}}"><a>Sesiones</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('spaces')}}"><a>Espacios</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('ar_markers')}}"><a>Marcadores</a></li>
                </ul>
            </li>
        @endcanatleast

        @canatleast(['users'])
            <li class="menu-item submenu-container"><a>Usuarios</a>
                <ul class="submenu">
                    <li class="submenu-item menu-link" data-route="{{route('users')}}"><a>Listado</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('roles')}}"><a>Roles</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('permissions')}}"><a>Permisos</a></li>
                </ul>
            </li>
        @endcanatleast

        @canatleast(['menus'])
            <li class="menu-item menu-link" data-route="{{route('menus')}}"><a>Menus</a></li>
        @endcanatleast --}}

        {{-- <li class="menu-item menu-link" data-route="{{route('media')}}"><a>Media</a></li> --}}
        
        @canatleast(['faqs'])
            <li class="menu-item submenu-container"><a>Faqs</a>
                <ul class="submenu">
                    <li class="submenu-item menu-link" data-route="{{route('faqs')}}"><a>Listado</a></li>
                    <li class="submenu-item menu-link" data-route="{{route('faqs_categories')}}"><a>Categorías</a></li>
                </ul>
            </li>
        @endcanatleast
{{-- 
        @canatleast(['sliders'])
            <li class="menu-item menu-link" data-route="{{route('sliders')}}"><a>Sliders</a></li>
        @endcanatleast

        @canatleast(['posts'])
            <li class="menu-item menu-link" data-route="{{route('posts')}}"><a>Entradas</a></li>
        @endcanatleast

        @canatleast(['custom_ar_markers'])
            <li class="menu-item menu-link" data-route="{{route('custom_ar_markers')}}"><a>AR</a></li>
        @endcanatleast

        @canatleast(['tags'])
            <li class="menu-item menu-link" data-route="{{route('tags')}}"><a>Etiquetas</a></li>
        @endcanatleast

        @canatleast(['seo'])
            <li class="menu-item menu-link" data-route="{{route('seo')}}"><a>Seo</a></li>
        @endcanatleast

        @canatleast(['payments'])
            <li class="menu-item menu-link" data-route="{{route('payments')}}"><a>Pedidos</a></li>
        @endcanatleast

        @canatleast(['projects'])
            <li class="menu-item menu-link" data-route="{{route('projects')}}"><a>Tienda</a></li>
        @endcanatleast

        @canatleast(['courses'])
            <li class="menu-item submenu-container"><a>Cursos</a>
                <ul class="submenu">
                    <li class="submenu-item menu-link" data-route="{{route('courses_categories')}}"><a>Categorías</a></li>  
                    <li class="submenu-item menu-link" data-route="{{route('courses')}}"><a>Puntuales</a></li>    
                    <li class="submenu-item menu-link" data-route="{{route('campus')}}"><a>Campus</a></li>    
                </ul>
            </li>
        @endcanatleast

        @canatleast(['formation'])
            <li class="menu-item submenu-container"><a>Formación</a>
                <ul class="submenu">
                    @canatleast(['subscriptors'])
                        <li class="submenu-item menu-link" data-route="{{route('subscriptors')}}"><a>Alumnos</a></li>
                    @endcanatleast

                    @canatleast(['activities'])
                        <li class="submenu-item menu-link" data-route="{{route('activities')}}"><a>Actividades</a></li>
                    @endcanatleast
                </ul>
            </li>
        @endcanatleast            --}}
    </ul>
</nav>

