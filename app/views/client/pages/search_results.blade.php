@extends('client.layouts.client')
@section('content')

    @include('client.includes.products', ['header_title' => "Resultados de busqueda para '$search'",
                                          'show_platform_icon' => true])
    
@stop