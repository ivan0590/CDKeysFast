@extends('admin.layouts.admin')
@section('content')

{{ Form::open(['route' => 'admin.massive_upload.store', 'files' => true, 'method' => 'POST']) }}
<div>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('xml', 'Fichero XML')}}
            </div>
            {{ Form::file('xml', ['class' => 'form-control']) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="input-group  col-md-12">
        {{ Form::submit('Cargar', ['class' => 'btn btn-primary  col-md-2 col-md-offset-5']) }}
    </div>
</div>

{{ Form::close() }}

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
                    <h4>Acciones realizadas con éxito en el grupo de {{ $key }}</h4>
                    @foreach($successBag as $message)
                    <div>
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
                    <h4>{{ $key }}</h4>
                    @foreach($errorBag->all() as $error)
                    <div>
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