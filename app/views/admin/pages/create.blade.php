@extends('admin.layouts.admin')
@section('content')

{{-- Selección de edición --}}
<ul class="nav nav-tabs">
    @foreach($tabs as $resource => $label)
    <li role="presentation" class="{{ $restful === $resource ? 'active' : '' }}">
        {{ HTML::linkRoute("admin.$resource.create", $label) }}
    </li>
    @endforeach
</ul>

{{-- Formulario de creación --}}
<div class="panel panel-default">


    <div class="panel-body">

        {{ Form::open(['route' => "admin.$restful.store", 'files' => true, 'method' => 'POST']) }}
       
        @include("admin.includes.forms.$restful")    

        <div class="form-group">
            <div class="input-group  col-md-12">
                {{ Form::submit('Guardar', ['class' => 'btn btn-primary  col-md-2 col-md-offset-5']) }}
            </div>
        </div>

        {{ Form::close() }}

        @foreach($errors->create->all() as $error)
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            {{ $error }}
        </div>
        @endforeach

        @if(Session::get('save_success'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            {{ Session::get('save_success') }}
        </div>
        @endif
    </div>
</div>

@stop