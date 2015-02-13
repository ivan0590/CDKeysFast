<div>
    
    
    {{-- Barra superior --}}
    <div class="navbar navbar-default">

        {{-- Cabecera --}}
        <div class="navbar-collapse navbar-header">
            <h3>{{ $header_title }}</h3>
        </div>
        
        {{-- Ordenación de productos --}}
        <div class="navbar-collapse navbar-form navbar-right">
            
            <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="sorter" data-toggle="dropdown" aria-expanded="true">
                    Ordenar por
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="sorter">


                    <li role="presentation">
                        <a role="menuitem"
                           tabindex="-1" 
                           href="{{ URL::route(Route::currentRouteName()) }}">
                            Nombre A-Z
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem"
                           tabindex="-1" 
                           href="{{ URL::route(Route::currentRouteName(), ['sort' => 'name', 'sort_dir' => 'desc']) }}">
                            Nombre Z-A
                        </a>
                    </li>
                    @if(Auth::check())
                    <li role="presentation">
                        <a role="menuitem"
                           tabindex="-1" 
                           href="{{ URL::route(Route::currentRouteName(), ['sort' => 'discount', 'sort_dir' => 'asc']) }}">
                            Menores descuentos
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem"
                           tabindex="-1" 
                           href="{{ URL::route(Route::currentRouteName(), ['sort' => 'discount', 'sort_dir' => 'desc']) }}">
                            Mayores descuentos
                        </a>
                    </li>
                    @else
                    <li role="presentation">
                        <a role="menuitem"
                           tabindex="-1" 
                           href="{{ URL::route(Route::currentRouteName(), ['sort' => 'price', 'sort_dir' => 'asc']) }}">
                            Precio ascendente
                        </a>
                    </li>
                    <li role="presentation">
                        <a role="menuitem"
                           tabindex="-1" 
                           href="{{ URL::route(Route::currentRouteName(), ['sort' => 'price', 'sort_dir' => 'desc']) }}">
                            Precio descendente
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>

    {{-- Productos --}}
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

        {{-- Paginación --}}
        <div class="col-md-4 col-md-offset-4 text-center">
            {{ $products->links() }}
        </div>
    </div>    
</div>