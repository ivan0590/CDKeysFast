@extends('admin.layouts.admin')
@section('content')

<div class="modal fade" id="modal-erase-results" tabindex="-1" role="dialog" aria-labelledby="Errores al borrar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content col-md-8 col-md-offset-2">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Errores al borrar</h4>
            </div>
            <div class="modal-body">
                @foreach($errors->create->all() as $error)
                <div class="alert alert-danger">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    {{ $error }}
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Selección de creación --}}
<ul class="nav nav-tabs">
    @foreach($tabs as $resource => $label)
    <li role="presentation" class="{{ $restful === $resource ? 'active' : '' }}">
        {{ HTML::linkRoute("$resource.edition", $label) }}
    </li>
    @endforeach
</ul>

{{-- Tabla de edición --}}
<div class="panel panel-default">

    <div class="panel-body">

        <table class = "table">
            <thead>
                <tr>
                    @foreach($header as $th)
                    <th>{{ $th }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($data->getCollection()->toArray() as $tr)
                <tr>
                    @foreach($tr as $td)
                    <td>{{ $td }}</td>
                    @endforeach
                    <td>
                        <a href = "{{ URL::route("$restful.edit", ['id' => $tr['id']]) }}">
                            <span class = "glyphicon glyphicon-pencil"></span>
                        </a>
                    </td>
                    <td>
                        <button type = 'button' class="btn-link" data-toggle="modal" data-target="#modal-{{ $tr['id'] }}">
                            <span  class="glyphicon glyphicon-trash"></span>
                        </button>


                        <div class="modal fade" id="modal-{{ $tr['id'] }}" tabindex="-1" role="dialog" aria-labelledby="Borrar elemento" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content col-md-8 col-md-offset-2">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Borrar elemento</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas borrar este elemento?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="pull-left btn btn-default" data-dismiss="modal">Cancelar</button>
                                        {{ Form::open(['route' => ["$restful.destroy", $tr['id']], 'class' => 'pull-right', 'method' => 'DELETE']) }}
                                        <button type="submit" class="btn btn-danger">Borrar</button>
                                        {{ Form::close() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    <div class="col-md-12 text-center">
        {{ $data->links() }}
    </div>
</div>
@stop