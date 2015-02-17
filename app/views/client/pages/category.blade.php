@extends('client.layouts.client')
@section('content')



@include('client.includes.products_list',['header_title' => "Productos en $category->name",
                                     'header_icon_path'  => $platform->icon_path,
                                     'show_platform_icon' => false])

@stop