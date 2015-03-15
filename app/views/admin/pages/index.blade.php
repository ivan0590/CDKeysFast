@extends('admin.layouts.admin')
@section('specific_head')
{{-- Labda --}}
{{ HTML::style('vendor/ladda-bootstrap-master/dist/ladda-themeless.css') }}
{{ HTML::script('vendor/ladda-bootstrap-master/dist/spin.js') }}
{{ HTML::script('vendor/ladda-bootstrap-master/dist/ladda.js') }}

{{ HTML::script('js/admin-index.js') }}
@stop
@section('content')


{{-- Selección de creación --}}
<ul class="nav nav-tabs">
    @foreach($tabs as $resource => $label)
    <li role="presentation" class="{{ $restful === $resource ? 'active' : '' }}">

        <a href="{{ URL::route("admin.$resource.index") }}">
            {{ $label }}
        </a>
    </li>
    @endforeach
    <li class="pull-right">
        <button class="btn btn-link" id="show-creation-form" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
            <span class="glyphicon glyphicon-plus"></span> Agregar nuevo
        </button>
    </li>
</ul>

{{-- Creación --}}
<div class="{{ $errors->hasBag('create') ? 'collapse in' : 'collapse' }}" id="collapseExample">
    <div class="well clearfix">
        {{ Form::open(['route' => "admin.$restful.store", 'files' => true, 'method' => 'POST']) }}

        @include("admin.includes.forms.$restful")    

        <div class="form-group row">
            <div class="input-group col-md-12">
                {{ Form::submit('Guardar', ['class' => 'btn btn-primary  center-block']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
</div>

{{-- Tabla de edición --}}
<div class="panel panel-default">
    <div id="table-container" data-url="{{ URL::route("admin.$restful.index") }}" class="panel-body">
        @include('admin.includes.index_table')
    </div>
</div>

{{-- Ventana modal para borrados --}}
<div class="modal fade" id="modal-erase" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close cancel-erase" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Borrar elementos</h4>
            </div>
            <div class="modal-body">
                <p class="text-center"></p>
            </div>
            <div class="modal-footer">

                <button  type="button" class="pull-left btn btn-default cancel-erase" data-dismiss="modal">Cancelar</button>

                <button id="multiple-delete" type="button" class="pull-right btn btn-danger ladda-button" data-style="expand-left"
                        data-base-url="{{ URL::route("admin.$restful.index") }}">
                    <span class="ladda-label">Borrar</span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Ventana modal para mensajes de error --}}
<div class="modal fade" id="modal-results" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mensaje</h4>
            </div>
            <div class="modal-body">
                @foreach($errors->getBags() as $bag)
                    @foreach($bag->all() as $error)
                    <div class="alert alert-danger">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        {{ $error }}
                    </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop