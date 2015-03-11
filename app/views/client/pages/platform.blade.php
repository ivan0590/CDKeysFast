@extends('client.layouts.client')
@section('content')

<div>
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h3 class="navbar-text">Categorías en {{ $platform->name }}</h3>
        </div>

        <div class="panel-body">

            <ul class="nav">
                @foreach ($categories as $category)
                <li class=" nav-pills text-left col-md-3">
                    <a href="{{ URL::route('platform.category.show', ['platform_id' => $platform->id, 'category_id' => $category->id]) }}" >
                        {{ $category->name.' ('.$category->products_count.')' }}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>        
</div>

@include('client.includes.products_list',['header_title' => "Productos destacados " . (Auth::check() ? 'con descuento' : '') . " en $platform->name",
                                     'header_icon_path'  => null,
                                     'show_platform_icon' => false])

@stop