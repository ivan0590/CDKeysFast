@extends('client.layouts.client')
@section('content')

<div>
    <div class="panel panel-default">
        <div class="panel-heading clearfix">
            <h3 class="navbar-text">Categorías en {{ $platformName }}</h3>
        </div>

        <div class="panel-body">

            @foreach ($categories as $chunk)
                <ul class="nav">
                @foreach ($chunk as $category)
                <li class=" nav-pills text-left col-md-2">
                        <a href="#category" >
                            {{ Form::label(null, $category->name) }}
                        </a>
                    </li>
                @endforeach
                </ul>
            @endforeach
        </div>
    </div>        
</div>

@include('client.includes.products',['header_title' => "Productos destacados en $platformName",
                                     'show_platform_icon' => false])
@stop

@stop