@extends('client.layouts.client')
@section('content')
<div class="panel panel-default">

    {{-- Cabecera con el nombre, precio y plataforma --}}
    <div class="panel-heading clearfix">

        <h3 class="pull-left navbar-text">
            {{ HTML::image($product->platform->icon_path, $product->platform->name, ['class' => 'platform-image']) }}
            {{ $product->game->name }}
        </h3>


        <h3 class="navbar-text pull-right">
            @if(Auth::check() && $product->discount)
            {{ round($product->price * ((100 - $product->discount) / 100), 2, PHP_ROUND_HALF_UP ) }} € 
            <span class="h4">
                <span class="label label-primary">-{{ round($product->discount, 2, PHP_ROUND_HALF_UP ) }}%</span>
            </span>
            @else
            {{ round($product->price, 2, PHP_ROUND_HALF_UP ) }} €
            @endif
        </h3>
    </div>

    {{-- Resto de los datos del juego --}}
    <div class="panel-body">

        {{-- Columna izquierda con la imagen y los detalles técnicos --}}
        <div class="col-md-3 product-info">
            <div class="center-block">

                {{ HTML::image($product->game->thumbnail_image_path, $product->game->name) }}

                <h4>Datos técnicos</h4>
                <dl class="product-info-content">
                    <dt>Idiomas del audio:</dt>
                    <dd>
                        @foreach($product->audioLanguages as $language)
                        {{ $language->name }}
                        @if($language !== $product->audioLanguages->last())
                        ,
                        @endif
                        @endforeach
                    </dd>

                    <dt>Idiomas del texto:</dt>
                    <dd>
                        @foreach($product->textLanguages as $language)
                        {{ $language->name }}
                        @if($language !== $product->textLanguages->last())
                        ,
                        @endif
                        @endforeach
                    </dd>
                    <dt>Un jugador:</dt>
                    <dd>
                        @if($product->singleplayer)
                        SI
                        @else
                        NO
                        @endif
                    </dd>

                    <dt>Multijugador:</dt>
                    <dd>
                        @if($product->multiplayer)
                        SI
                        @else
                        NO
                        @endif
                    </dd>

                    <dt>Cooperativo:</dt>
                    <dd>
                        @if($product->cooperative)
                        SI
                        @else
                        NO
                        @endif
                    </dd>
                </dl>
            </div>
        </div>

        <div class="col-md-8 col-md-offset-1">
            {{-- Barra con el stock --}}
            <div class="row text-center product-info">
                <span class="h3">Unidades en stock:  {{ $product->stock }}</span>
            </div>

            {{-- Datos generales --}}
            <div class="row product-info">

                <h4>Datos generales</h4>
                <dl class="dl-horizontal col-md-6 col-md-offset-3">
                    <dt>Categoria:</dt>
                    <dd> {{ $product->game->category->name }} </dd>

                    <dt>Desarrolladoras:</dt>
                    <dd>
                        @foreach($product->developers as $developer)
                        {{ $developer->name }}
                        @if($language !== $product->textLanguages->last())
                        ,
                        @endif
                        @endforeach
                    </dd>

                    <dt>Distribuidora:</dt>
                    <dd> {{ $product->publisher->name }} </dd>

                    <dt>Calificación por edad:</dt>
                    <dd> {{ $product->game->agerate->name }} </dd>

                    <dt>Fecha de lanzamiento:</dt>
                    <dd> {{ $product->launch_date }} </dd>
                </dl>
            </div>

            {{-- Descripción --}}
            <div class="row product-info">

                <h4>Descripción</h4>
                <p class="product-info-content"> {{ $product->game->description }} </p>
            </div>
        </div>
    </div>
</div>
@stop