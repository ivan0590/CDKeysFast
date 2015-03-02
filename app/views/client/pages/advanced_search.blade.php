@extends('client.layouts.client')
@section('content')


<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="navbar-text">Búsqueda avanzada</h3>
    </div>

    <div class="panel-body">

        <div class="col-md-8 col-md-offset-2">


            {{ Form::open(['action' => 'search.advanced', 'method' => 'GET']) }}

            <div class="form-group row">

                <div class="col-md-8">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('as-name', 'Nombre')}}
                        </div>                
                        {{ Form::text('as-name', null, ['class' => 'form-control']) }}
                    </div>                
                </div>  
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('as-price', 'Precio hasta')}}
                        </div>
                        {{ Form::number('as-price', null, ['min' => '1', 'step' => '0.01', 'class' => 'form-control']) }}
                    </div>
                </div>


            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('as-platform', 'Plataforma')}}
                        </div>
                        {{ Form::select('as-platform', $platforms, null, ['class' => 'form-control']) }}
                    </div>                
                </div>                

                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('as-category', 'Categoría')}}
                        </div>
                        {{ Form::select('as-category', $categories, null, ['class' => 'form-control']) }}
                    </div>                
                </div>                
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('as-publisher', 'Distribuidora')}}
                        </div>
                        {{ Form::select('as-publisher', $publishers, null, ['class' => 'form-control']) }}
                    </div>
                </div>
                

                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('as-agerate', 'Calificación por edad')}}
                        </div>
                        {{ Form::select('as-agerate', $agerates, null, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6 col-md-offset-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('as-launch_date', 'Lanzado después del')}}
                        </div>
                        {{ Form::input('date', 'as-launch_date', null, ['min' => '1990-01-01', 'max' => date('Y-m-d'), 'class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                @foreach([
                'as-singleplayer' => 'Un jugador',
                'as-multiplayer'  => 'Multijugador',
                'as-cooperative'  => 'Cooperativo'] as $name => $label)
                <div class="col-md-4">
                    <div class="input-group">

                        <div class="input-group-addon text-capitalize">
                            {{ Form::label($name, $label)}}
                        </div>

                        {{ Form::select($name,[null => 'Cualquiera', true => 'SI', false => 'NO'], null, ['class' => 'form-control']) }}
                    </div>
                </div>
                @endforeach
            </div>

            <div class="form-group row">
                <div class="input-group col-md-12 text-center">
                    <label class="checkbox-inline">
                        {{ Form::checkbox('as-stock', 'stock', true) }}
                        Incluir productos sin stock
                    </label>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group  col-md-12">
                    {{ Form::submit('Buscar', ['class' => 'btn btn-primary  col-md-4 col-md-offset-4']) }}
                </div>
            </div>
            {{ Form::close() }}

        </div>
    </div>
</div>

@if(!empty(Input::get()))
@include('client.includes.products_list', ['header_title' => "Resultados de busqueda",
                                      'header_icon_path'  => null,
                                      'show_platform_icon' => true])
@stop
@endif



@stop