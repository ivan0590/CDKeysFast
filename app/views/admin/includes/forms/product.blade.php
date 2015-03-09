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

    <div class="col-md-3">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('price', 'Precio')}}
            </div>
            {{ Form::number('price', null, ['min' => '0.01', 'step' => '0.01', 'class' => 'form-control']) }}
        </div>
    </div>

    <div class="col-md-3">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('discount', 'Descuento')}}
            </div>
            {{ Form::number('discount', null, ['min' => '0', 'step' => '0.01', 'max' => '100', 'class' => 'form-control']) }}
        </div>
    </div>

    <div class="col-md-2">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('stock', 'Stock')}}
            </div>
            {{ Form::number('stock', null, ['min' => '0', 'step' => '1', 'class' => 'form-control']) }}
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('launch_date', 'Fecha de lanzamiento')}}
            </div>
            {{ Form::input('text', 'launch_date', null, ['class' => 'form-control date-selector']) }}
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