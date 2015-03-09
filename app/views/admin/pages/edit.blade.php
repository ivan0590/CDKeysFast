@extends('admin.layouts.admin')
@section('content')

{{-- Formulario de creación --}}
<div class="panel panel-default">

    {{-- Cabecera --}}
    <div class="panel-heading clearfix">
        <h3 class="navbar-text">{{ $header_title }}</h3>
    </div>
    
    
    <div class="panel-body">

        {{ Form::model($model,['route' => ["admin.$restful.update", $model->id], 'files' => true, 'method' => 'PUT']) }}
        
        @include("admin.includes.forms.$restful")    

        <div class="form-group">
            <div class="input-group  col-md-12">
                {{ Form::submit('Actualizar', ['class' => 'btn btn-primary  col-md-2 col-md-offset-5']) }}
            </div>
        </div>

        {{ Form::close() }}

        @foreach($errors->update->all() as $error)
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