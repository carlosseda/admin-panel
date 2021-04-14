<?php

return [

    /* Contenido estático de la ruta faq_categoria
    |--------------------------------------------------------------------------
    | EasyDevel, última actualización de esta documentación realizada el 16/11/2017
    |
    | page_title: Etiqueta del título de la página utilizada en el archivo /views/partials/breadcrumbs
    |
    | parent_section: Etiqueta del nombre de la sección padre utilizada en el archivo /views/partials/breadcrumbs
    |
    | subsection: Etiqueta del nombre de la subsección (en el caso de que esta vista tuviera una sección por encima),
    | puede dejarse en blanco si no fuera una subsección, utilizada en el archivo /views/partials/breadcrumbs
    |
    | new: Etiqueta de nuevo elemento, utilizada en el archivo /views/partials/breadcrumbs.
    |
    | edit: Etiqueta de edición de elemento, utilizada en el archivo  /views/partials/breadcrumbs. Recibe como 
    | parametro el nombre del elemento (:name).
    |
    | modal: Mensaje de aviso en la ventana modal al eliminar un elemento, utilizada en el archivo 
    | /views/partials/delete_modal.
    |
    |--------------------------------------------------------------------------
    */

    'page_title' => "Clientes",
    'parent_section' => "Clientes",
    'subsection' => '',
    'new' => 'Nuevo cliente',
    'edit' => 'Editando :name',
    'modal'=> '¿Está seguro de borrar el cliente :name ?'

];