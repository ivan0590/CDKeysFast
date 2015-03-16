@extends('client.client_layout')
@section('content')

@include('client.includes.products_list',['header_title' => "Resultados de busqueda".(empty(Input::get('ss-name')) ? '' : " para '".Input::get('ss-name')."'"),
                                     'header_icon_path'  => null,
                                     'show_platform_icon' => true])
@stop