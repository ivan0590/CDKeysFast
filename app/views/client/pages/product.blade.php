@extends('client.layouts.client')
@section('content')
<div class="panel panel-default">

    {{-- Cabecera con el nombre, precio y plataforma --}}
    <div class="panel-heading clearfix">
        {{ HTML::image($product->platform->icon_path, $product->platform->name, ['class' => 'pull-left']) }}
        <h3 class="navbar-text">{{ $product->game->name }}</h3>

        <h3 class="navbar-text pull-right">
            @if(Auth::check() && $product->discount)
                {{ round($product->price * ((100 - $product->discount) / 100), 2, PHP_ROUND_HALF_UP ) }} € 
                <span class="label label-default">-{{ round($product->discount, 2, PHP_ROUND_HALF_UP ) }}%</span>
            @else
                {{ round($product->price, 2, PHP_ROUND_HALF_UP ) }} €
            @endif
        </h3>
    </div>

    {{-- Resto de los datos del juego --}}
    <div class="panel-body">

        {{-- Columna izquierda con la imagen y los detalles técnicos --}}
        <div class="panel panel-default col-md-3">
            <div class="panel-body">
                {{ HTML::image($product->game->thumbnail_image_path) }}

                <h4>Datos técnicos</h4>
                <dl>
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
                    <dt>Un jugador:<dt>
                    <dd>
                        @if($product->singleplayer)
                        SI
                        @else
                        NO
                        @endif
                    </dd>

                    <dt>Multijugador:<dt>
                    <dd>
                        @if($product->multiplayer)
                        SI
                        @else
                        NO
                        @endif
                    </dd>

                    <dt>Cooperativo:<dt>
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

        {{-- Barra con el stock --}}
        <div class="navbar navbar-default col-md-8 col-md-offset-1 text-center">
            <h3>Unidades en stock:  {{ $product->stock }}</h3>
        </div>

        {{-- Datos generales --}}
        <div class="panel panel-default col-md-8 col-md-offset-1">
            <div class="panel-body">

                <h4>Datos generales</h4>
                <dl>
                    <dt class="pull-left">Categoria:</dt>
                    <dd> {{ $product->game->category->name }} </dd>

                    <dt class="pull-left">Desarrolladoras:</dt>
                    <dd>
                        @foreach($product->developers as $developer)
                        {{ $developer->name }}
                        @if($language !== $product->textLanguages->last())
                        ,
                        @endif
                        @endforeach
                    </dd>

                    <dt class="pull-left">Distribuidora:<dt>
                    <dd> {{ $product->publisher->name }} </dd>

                    <dt class="pull-left">Calificación por edad:<dt>
                    <dd> {{ $product->game->agerate->name }} </dd>

                    <dt class="pull-left">Fecha de lanzamiento:<dt>
                    <dd> {{ $product->launch_date }} </dd>
                </dl>
            </div>
        </div>

        {{-- Descripción --}}
        <div class="panel panel-default col-md-8 col-md-offset-1">
            <div class="panel-body">

                <h4>Descripción</h4>
                <p> {{ $product->game->description }} </p>
            </div>
        </div>
    </div>
</div>
@stop