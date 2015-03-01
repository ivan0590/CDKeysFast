@extends('admin.layouts.admin_create')
@section('panel_content')

<div class="panel-body">

    {{ Form::open(['route' => 'game.store', 'method' => 'POST', 'files' => true]) }}

    <div class="form-group row">

        <div class="col-md-6">
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('name', 'Nombre')}}
                </div>
                {{ Form::text('name', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-addon">
                    {{ Form::label('category_id', 'Categoría')}}
                </div>
                {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
            </div>               
        </div>  

        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-addon">
                    {{ Form::label('agerate_id', 'Calificación por edad')}}
                </div>
                {{ Form::select('agerate_id', $agerates, null, ['class' => 'form-control']) }}
            </div>                
        </div>                        
    </div>

    <div class="form-group row">

        <div class="col-md-6">
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('description', 'Descripción')}}
                </div>
                {{ Form::textarea('description', null, ['class' => 'form-control']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('thumbnail_image_path', 'Imagen para miniaturas')}}
                </div>
                {{ Form::file('thumbnail_image_path', ['class' => 'form-control']) }}
            </div>
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('offer_image_path', 'Imagen para ofertas')}}
                </div>
                {{ Form::file('offer_image_path', ['class' => 'form-control']) }}
            </div>
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