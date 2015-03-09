@extends('admin.layouts.admin')
@section('content')

<div class="col-md-6 col-md-offset-3">
    {{ Form::open(['route' => 'admin.massive_upload.store', 'files' => true, 'method' => 'POST']) }}
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('xml', 'Fichero XML')}}
            </div>
            {{ Form::file('xml', ['class' => 'form-control']) }}
            <div class="input-group-btn">
                {{ Form::submit('Cargar', ['class' => 'btn btn-primary']) }}
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>

<div class="modal fade" id="modal-results" tabindex="-1" role="dialog" aria-labelledby="Errores al borrar" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Resultados de la carga masiva</h4>
            </div>
            <div class="modal-body">

                @foreach((Session::get('save_success') ?: [] ) as $key => $successBag)
                @if(!empty($successBag))
                <div class="alert alert-success">
                    <h4 class="alert-success">Acciones realizadas con éxito en el grupo de {{ $key }}</h4>
                    @foreach($successBag as $message)
                    <div class="alert-success">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        {{ $message }}
                    </div>
                    @endforeach
                </div>
                @endif
                @endforeach

                @foreach($errors->getBags() as $key => $errorBag)
                @if(!$errorBag->isEmpty())
                <div class="alert alert-danger">
                    <h4 class="alert-danger">{{ $key }}</h4>
                    @foreach($errorBag->all() as $error)
                    <div class="alert-danger">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        {{ $error }}
                    </div>
                    @endforeach
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

@stop