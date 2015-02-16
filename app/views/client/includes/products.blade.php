<div>


    <div class="panel panel-default">

        {{-- Barra superior --}}
        <div class="panel-heading clearfix">

            {{-- Cabecera --}}
            <h3 class="pull-left navbar-text">{{ $header_title }}</h3>

            {{-- Ordenación de productos --}}
            <div class="pull-right navbar-form">

                @if($products->getTotal() !== 0)
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="sorter" data-toggle="dropdown" aria-expanded="true">
                        Ordenar por
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="sorter">


                        <li role="presentation">
                            <a role="menuitem"
                               tabindex="-1" 
                               href="{{ URL::route(Route::currentRouteName(),
                                                   array_merge(Input::all(),
                                                               ['sort' => 'name', 'sort_dir' => 'asc', 'page' => '1'])) }}">
                                Juego A-Z
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem"
                               tabindex="-1" 
                               href="{{ URL::route(Route::currentRouteName(),
                                                   array_merge(Input::all(),
                                                               ['sort' => 'name', 'sort_dir' => 'desc', 'page' => '1'])) }}">
                                Juego Z-A
                            </a>
                        </li>
                        @if(Auth::check())
                        <li role="presentation">
                            <a role="menuitem"
                               tabindex="-1" 
                               href="{{ URL::route(Route::currentRouteName(),
                                                   array_merge(Input::all(),
                                                               ['sort' => 'discount', 'sort_dir' => 'asc', 'page' => '1'])) }}">
                                Menores descuentos
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem"
                               tabindex="-1" 
                               href="{{ URL::route(Route::currentRouteName(),
                                                   array_merge(Input::all(),
                                                               ['sort' => 'discount', 'sort_dir' => 'desc', 'page' => '1'])) }}">
                                Mayores descuentos
                            </a>
                        </li>
                        @else
                        <li role="presentation">
                            <a role="menuitem"
                               tabindex="-1" 
                               href="{{ URL::route(Route::currentRouteName(),
                                                   array_merge(Input::all(),
                                                               ['sort' => 'price', 'sort_dir' => 'asc', 'page' => '1'])) }}">
                                Precio ascendente
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem"
                               tabindex="-1" 
                               href="{{ URL::route(Route::currentRouteName(),
                                                   array_merge(Input::all(),
                                                               ['sort' => 'price', 'sort_dir' => 'desc', 'page' => '1'])) }}">
                                Precio descendente
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>

        {{-- Productos --}}
        <div class="panel-body">
            <div class="col-md-12">

                <ul class="thumnails col-md-11">
                    @foreach ($products as $index => $product)
                    <li class="col-md-3 col-md-offset-1 thumbnail">
                        <a href="#product">
                            {{ HTML::image($product->game->thumbnail_image_path, $product->game->name) }}
                        </a>

                        <div class="caption">
                            @if($show_platform_icon)
                            <a href="#platform" class="pull-left">
                                {{ HTML::image($product->platform->icon_path, $product->platform->name) }}
                            </a>
                            @endif
                            <a href="#product">
                                <div class="text-center">

                                    @if(Auth::check() && $product->discount)
                                    <h3>
                                        {{ floatval($product->price * ((100 - $product->discount) / 100)) }} € 
                                        <span class="label label-default">-{{ floatval($product->discount)}}%</span>
                                    </h3>
                                    @else
                                    <h3>{{ floatval($product->price) }} €</h3>
                                    @endif
                                </div>
                            </a>
                        </div>
                    </li>
                    @endforeach
                </ul>

            </div>
            @if($products->getTotal() === 0)
            <h3 class="text-center">No se han encontrado coincidencias</h3>
            @endif
        </div>    
    </div>

    {{-- Paginación --}}
    <div class="col-md-4 col-md-offset-4 text-center">
        {{ $products->appends(Input::all())->links() }}
    </div>
</div>