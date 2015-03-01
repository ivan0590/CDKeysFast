@extends('client.layouts.client')
@section('content')
<div>

    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            <li data-target="#carousel-example-generic" data-slide-to="3"></li>
            <li data-target="#carousel-example-generic" data-slide-to="4"></li>
        </ol>

        <div class="carousel-inner" role="listbox">
            
            @foreach ($offerProducts as $index => $product)
            @if($index === 0)
            <div class="item active">
            @else
            <div class="item ">
            @endif            
                <a href="{{ URL::route('platform.category.product.show',
                                                   ['platform_id' => $product->platform->id,
                                                    'category_id' => $product->game->category_id,
                                                    'product_id'  => $product->id
                                                   ]) }}">
                    {{ HTML::image($product->game->offer_image_path, $product->game->name, ['class' => 'img-responsive center-block']) }}
                    <div class="carousel-caption">
                        <h2>
                            {{ $product->game->name }}
                            ({{ HTML::image($product->platform->icon_path, $product->game->name) }})
                        </h2>
                        
                        @if(Auth::check())
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
            @endforeach
        
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    @if(Auth::check())
    @include('client.includes.products_list', ['header_title' => 'Productos destacados con descuento',
                                          'header_icon_path'  => null,
                                          'show_platform_icon' => true])
    @else
    @include('client.includes.products_list', ['header_title' => 'Productos destacados',
                                          'header_icon_path'  => null,
                                          'show_platform_icon' => true])
    @endif
    
</div>
@stop