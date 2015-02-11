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
                <a href="#product">
                    {{ HTML::image($product->game->offer_image_path, $product->game->name, ['class' => 'img-responsive center-block']) }}
                    <div class="carousel-caption">
                        {{ $product->game->name }}
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
    @include('client.includes.products_header', ['title' => 'Productos destacados con descuento'])
    @else
    @include('client.includes.products_header', ['title' => 'Productos destacados'])
    @endif
    
    <div class="col-md-12">
        <div class="thumnails col-md-11">
            @foreach ($highlightedProducts as $index => $product)
            <div class="col-md-3 col-md-offset-1 thumbnail">
                <a href="#product">
                    {{ HTML::image($product->game->thumbnail_image_path, $product->game->name) }}
                    <div class="caption">
                        <p class="pull-right">{{ floatval($product->price) }} €</p>
                        <p class="pull-left">{{ $product->platform->name }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

        <div class="col-md-4 col-md-offset-4 text-center">
            {{ $highlightedProducts->links() }}
        </div>
    </div>    

</div>
@stop