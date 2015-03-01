@extends('admin.layouts.admin_create')
@section('panel_content')

<div class="panel-body">

    {{ Form::open(['route' => 'product.store', 'method' => 'POST']) }}

    <div class="form-group row">

        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-addon">
                    {{ Form::label('game_id', 'Juego')}}
                </div>
                {{ Form::select('game_id', $games, null, ['class' => 'form-control']) }}
            </div>               
        </div>  

        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-addon">
                    {{ Form::label('platform_id', 'Plataforma')}}
                </div>
                {{ Form::select('platform_id', $platforms, null, ['class' => 'form-control']) }}
            </div>                
        </div>                        

        <div class="col-md-3">
            <div class="input-group">

                <div class="input-group-addon">
                    {{ Form::label('publisher_id', 'Distribuidora')}}
                </div>
                {{ Form::select('publisher_id', $publishers, null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-3">
            <label class="checkbox-inline">
                {{ Form::checkbox('highlighted', true, true) }}
                Destacado
            </label>
        </div>
    </div>

    <div class="form-group row">

        <div class="col-md-2">
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('price', 'Precio')}}
                </div>
                {{ Form::number('price', null, ['min' => '1', 'step' => '0.01', 'class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-md-2">
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('discount', 'Descuento')}}
                </div>
                {{ Form::number('discount', null, ['min' => '0', 'step' => '0.01', 'max' => '100', 'class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-md-2">
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('stock', 'Stock')}}
                </div>
                {{ Form::number('stock', null, ['min' => '0', 'step' => '1', 'class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('launch_date', 'Fecha de lanzamiento')}}
                </div>
                {{ Form::input('date', 'launch_date', null, ['min' => '1990-01-01', 'max' => date('Y-m-d'), 'class' => 'form-control']) }}
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

                {{ Form::select($name,[true => 'SI', false => 'NO'], null, ['class' => 'form-control']) }}
            </div>
        </div>
        @endforeach
    </div>

    <div class="form-group">
        <div class="input-group  col-md-12">
            {{ Form::submit('Guardar', ['class' => 'btn btn-primary  col-md-2 col-md-offset-5']) }}
        </div>
    </div>
    {{ Form::close() }}

</div>
@stop