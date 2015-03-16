@extends('client.client_layout')
@section('content')


<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="navbar-text">Búsqueda avanzada</h3>
    </div>

    <div class="panel-body">

        <div class="col-md-12">


            {{ Form::open(['action' => 'search.advanced', 'method' => 'GET']) }}

            <div class="form-group row">

                <div class="col-md-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('name', 'Nombre')}}
                        </div>                
                        {{ Form::text('name', null, ['class' => 'form-control']) }}
                    </div>                
                </div>  
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('price', 'Precio hasta')}}
                        </div>
                        {{ Form::number('price', null, ['min' => '0.01', 'step' => '0.01', 'class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('launch_date', 'Lanzado después del')}}
                        </div>
                        {{ Form::input('text', 'launch_date', null, ['class' => 'form-control date-selector']) }}
                    </div>
                </div>

            </div>

            <div class="form-group row">
                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('platform', 'Plataforma')}}
                        </div>
                        {{ Form::select('platform', $platforms, null, ['class' => 'form-control']) }}
                    </div>                
                </div>                

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('category', 'Categoría')}}
                        </div>
                        {{ Form::select('category', $categories, null, ['class' => 'form-control']) }}
                    </div>                
                </div>                

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('publisher', 'Distribuidora')}}
                        </div>
                        {{ Form::select('publisher', $publishers, null, ['class' => 'form-control']) }}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('agerate', 'Calificación por edad')}}
                        </div>
                        {{ Form::select('agerate', $agerates, null, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                @foreach([
                'singleplayer' => 'Un jugador',
                'multiplayer'  => 'Multijugador',
                'cooperative'  => 'Cooperativo'] as $name => $label)
                <div class="col-md-3">
                    <div class="input-group">

                        <div class="input-group-addon text-capitalize">
                            {{ Form::label($name, $label)}}
                        </div>

                        {{ Form::select($name,[null => 'Cualquiera', true => 'SI', false => 'NO'], null, ['class' => 'form-control']) }}
                    </div>
                </div>
                @endforeach

                <div class="col-md-3">
                    <div class="input-group">
                        <label class="checkbox-inline">
                            {{ Form::checkbox('stock', 'stock', true) }}
                            Incluir productos sin stock
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="input-group col-md-12">
                    {{ Form::submit('Buscar', ['class' => 'btn btn-primary  center-block']) }}
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
@endif
@stop



@stop