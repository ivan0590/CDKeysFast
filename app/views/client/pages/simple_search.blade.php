@extends('client.layouts.client')
@section('content')

@include('client.includes.products',
['header_title' => "Resultados de busqueda".(empty(Input::get('ss-name')) ? '' : " para '".Input::get('ss-name')."'"),
'show_platform_icon' => true])
@stop