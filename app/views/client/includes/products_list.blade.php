<div class="products-list">
    <div class="panel panel-default">

        {{-- Barra superior --}}
        <div class="panel-heading clearfix">

            {{-- Cabecera --}}
            <h3 class="pull-left navbar-text">
                @if($header_icon_path)
                {{ HTML::image($header_icon_path, null, ['class' => 'platform-image']) }}
                @endif
                {{ $header_title }}
            </h3>

            {{-- Ordenación de productos --}}
            <div class="pull-right navbar-form">

                @if($products->getTotal() !== 0)
                <div class="dropdown">
                    <button class="btn btn-default dropdown-toggle" type="button" id="sorter" data-toggle="dropdown" aria-expanded="true">
                        Ordenar por 
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="sorter">
                        @foreach($orderBy as $order)                        
                        <li role="presentation">
                            <a role="menuitem"
                               tabindex="-1" 
                               href="{{ URL::route(Route::currentRouteName(),
                                                   array_merge(Input::all(), $order['parameters'])) }}">
                                {{ $order['label'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

        {{-- Productos --}}
        <div class="panel-body">
            <div class="col-md-12">

                <ul class="thumnails col-md-12">
                    @foreach ($products as $index => $product)
                    <li class="col-md-3">
                        <div class="thumbnail">

                            <a href="{{ URL::route('platform.category.product.show',
                                                   ['platform_id' => $product->platform->id,
                                                    'category_id' => $product->game->category_id,
                                                    'product_id'  => $product->id
                                                   ]) }}">
                                {{ HTML::image($product->game->thumbnail_image_path, $product->game->name, ['class' => 'img-responsive']) }}
                            </a>

                            <div class="caption clearfix">

                                @if($show_platform_icon)
                                <a href="{{ URL::route('platform.show',
                                                   ['platform_id' => $product->platform->id
                                                   ]) }}" class="pull-left">
                                    {{ HTML::image($product->platform->icon_path, $product->platform->name, ['class' => 'platform-image img-responsive img-thumbnail']) }}
                                </a>
                                @endif
                                <a href="{{ URL::route('platform.category.product.show',
                                                   ['platform_id' => $product->platform->id,
                                                    'category_id' => $product->game->category_id,
                                                    'product_id'  => $product->id
                                                   ]) }}">
                                    <div class="text-center h3 price">
                                        @if(Auth::check() && $product->discount && $product->discount > 0)
                                        {{ round($product->price * ((100 - $product->discount) / 100), 2, PHP_ROUND_HALF_UP ) }} € 
                                        <div class="h4">
                                            <span class="label label-primary">-{{ round($product->discount, 2, PHP_ROUND_HALF_UP ) }}%</span>
                                        </div>
                                        @else
                                        {{ round($product->price, 2, PHP_ROUND_HALF_UP ) }} €
                                        @endif
                                    </div>
                                </a>
                            </div>
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
    <div class="col-md-12 text-center">
        {{ $products->appends(Input::all())->links() }}
    </div>
</div>