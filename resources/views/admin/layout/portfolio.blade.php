@extends('admin.layout.master')

@section('content')

    <div class="{{$route}}-modal">
        @include("admin.".$route.".modal")
    </div>

    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="confirmDeleteModalTitle">Confirmación de borrado</h4>
                </div>

                <div class="modal-body">
                    <p>@lang('admin/'.$route.'.modal')</p>
                </div>

                <div class="modal-footer">
                    <div>
                        <form class="admin-delete-form" data-method="delete">
                            <a href=""  token="{{ csrf_token() }}" id="delete-button" class="btn btn-block btn-danger waves-effect waves-light"> 
                                <i class="fa fa-check m-r-5"></i> Sí
                            </a>
                        </form>
                    </div>
                    <div>
                        <a href="/admin/{{$route}}" class="btn btn-block btn-default waves-effect waves-light" data-dismiss="modal"> 
                            <i class="fa fa-times m-r-5">
                        </i> No</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    @include('admin.partials.breadcrumbs', ['route' => $route, 'parent_section' => $route, 'active' => ''])

    <div class="row">
        <div class="col-md-12">
            <div class="white-box" id="portfolio">
                
                @if($route == 'media')
                    <h3 class="box-title">Listado</h3>
                @else
                    <h3 class="box-title">Items</h3>
                @endif

                <div class="dropdown-divider"></div>

                <div class="row m-b-5">

                    @if($route == 'media')
                        @canatleast(['edit.media'])
                            <div class="col-lg-4 col-sm-4 col-xs-12 p-5">
                                <a id="new-media" class="btn btn-block btn-default waves-effect waves-light"> 
                                    <i class="fa fa-plus-circle m-r-5"></i> 
                                    Nuevo
                                </a>
                            </div>
                        @endcanatleast
                    @elseif($route == 'slides')
                        @canatleast(['edit.slides'])
                            <div class="col-lg-4 col-sm-4 col-xs-12 p-5">
                                <a id="new-slide" class="btn btn-block btn-default waves-effect waves-light"> 
                                    <i class="fa fa-plus-circle m-r-5"></i> 
                                    Nuevo
                                </a>
                            </div>
                        @endcanatleast
                    @elseif($route == 'rotulos')
                        @canatleast(['edit.rotulos'])
                            <div class="col-lg-4 col-sm-4 col-xs-12 p-5">
                                <a id="new-rotulo" class="btn btn-block btn-default waves-effect waves-light" route="{{route('rotulos_item_create')}}"> 
                                    <i class="fa fa-plus-circle m-r-5"></i> 
                                    Nuevo
                                </a>
                            </div>
                        @endcanatleast
                    @else
                        <div class="col-lg-4 col-sm-4 col-xs-12 p-5">
                            <a id="upload-button" class="btn btn-block btn-default waves-effect waves-light"  data-toggle="modal" data-target="#new-{{$route}}-modal"> 
                                <i class="fa fa-plus-circle m-r-5"></i> 
                                Nuevo
                            </a>
                        </div>
                    @endif
                          
                    @if($route == 'media')
                    <div class="col-lg-8 col-sm-8 col-xs-12 p-5">
                        <div class="filter-files col-lg-6 col-md-6 offset-lg-6 offset-md-6" route="{{route('media_filter')}}">
                            <select 
                                data-placeholder="Tipo de archivo"
                                id="filter-files"
                                class="form-control select2">
                                    <option></option>
                                    <option value="todos" name='todos'>Todos</option>
                                    <option value="imagenes" name='imagenes'>Imágenes</option>
                                    <option value="documentos" name='documentos'>Documentos</option>
                            </select>             
                        </div>
                    </div>
                    @endif
                </div>

                <div class="dropdown-divider"></div>

                <div class="table-responsive m-t-10" id="one-column-portfolio">
                    @yield('portfolio')
                </div>
            </div>
        </div>
    </div>
    
@endsection

