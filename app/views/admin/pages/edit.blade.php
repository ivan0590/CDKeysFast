@extends('admin.admin_layout')
@section('content')

{{-- Formulario de creación --}}
<div class="panel panel-default">

    {{-- Cabecera --}}
    <div class="panel-heading clearfix">
        <h3 class="navbar-text">{{{ $header_title }}}</h3>
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
        
    </div>
</div>

<div class="modal fade" id="modal-results" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Mensaje</h4>
            </div>
            <div class="modal-body">

                @if(Session::get('save_success'))
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                    {{{ Session::get('save_success') }}}
                </div>
                @endif

                @foreach($errors->update->all() as $error)
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    {{{ $error }}}
                </div>
                @endforeach

            </div>
        </div>
    </div>
</div>

@stop