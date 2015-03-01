@extends('admin.layouts.admin_create')
@section('panel_content')

<div class="panel-body">

    {{ Form::open(['route' => 'platform.store', 'method' => 'POST', 'files' => true, 'class' => 'col-md-6 col-md-offset-3']) }}

    <div class="form-group row">

        <div class="input-group ">
            <div class="input-group-addon">
                {{ Form::label('name', 'Nombre')}}
            </div>
            {{ Form::text('name', null, ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="input-group ">
            <div class="input-group-addon">
                {{ Form::label('icon_path', 'Icono')}}
            </div>
            {{ Form::file('icon_path', ['class' => 'form-control']) }}
        </div>
    </div>
    <div class="form-group row">
        <div class="input-group ">
            <div class="input-group-addon">
                {{ Form::label('description', 'Descripción')}}
            </div>
            {{ Form::textarea('description', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        <div class="input-group  col-md-12">
            {{ Form::submit('Guardar', ['class' => 'btn btn-primary  col-md-2 col-md-offset-5']) }}
        </div>
    </div>
    {{ Form::close() }}


</div>
@stop