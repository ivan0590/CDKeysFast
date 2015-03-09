@extends('client.layouts.client')
@section('content')
<div class="panel panel-default">

    {{-- Cabecera --}}
    <div class="panel-heading clearfix">
        <h3 class="navbar-text">Editar perfil</h3>
    </div>

    <div class="panel-body">

        <div class="col-md-6">

            {{-- Cambiar email --}}
            {{ Form::model($model, ['route' => ['update_email', Auth::id()],
                               'method' => 'POST']) }}
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('email', 'Email')}}
                        </div>
                        {{ Form::text('email', null, ['class' => 'form-control']) }}
                        <div class="input-group-btn">
                            {{ Form::submit('Cambiar email', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>

            </div>
            {{ Form::close() }}


            {{-- Cambiar contraseña --}}
            {{ Form::open(['route' => ['update_password', Auth::id()],
                               'method' => 'POST']) }}
            <div class="form-group">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('password', 'Contraseña')}}
                        </div>
                        {{ Form::password('password', ['class' => 'form-control']) }}

                        <div class="input-group-btn">
                            {{ Form::submit('Cambiar contraseña', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>

            </div>
            {{ Form::close() }}
        </div>

        {{-- Cambiar datos personales --}}
        <div class="col-md-6">

            {{ Form::model($model, ['route' => ['update_personal', Auth::id()],
                               'method' => 'POST'])  }}
            <div class="form-group row">

                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('name', 'Nombre')}}
                        </div>
                        {{ Form::text('name',  null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('surname', 'Apellidos')}}
                        </div>
                        {{ Form::text('surname',  null, ['class' => 'form-control']) }}
                    </div>
                </div>
            </div>

            <div class="form-group row">
                @if(Auth::user()->userable_type !== 'Admin')
                <div class="col-md-7">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('birthdate', 'Fecha de nacimiento') }}
                        </div>
                        {{ Form::input('text', 'birthdate', null, ['class' => 'form-control date-selector']) }}
                    </div>
                </div>

                <div class="col-md-5">
                    <div class="input-group">
                        <div class="input-group-addon">
                            {{ Form::label('dni', 'DNI')}}
                        </div>
                        {{ Form::text('dni', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                @endif
            </div>

            <div class="form-group">
                <div class="input-group col-md-12">
                    {{ Form::submit('Cambiar datos personales', ['class' => 'btn btn-primary  center-block']) }}
                </div>
            </div>

            {{ Form::close() }}
        </div>

        {{-- Darse de baja --}}

        {{ Form::open(['route' => ['unsuscribe', Auth::id()],
                               'method' => 'POST'])  }}

        <div class="form-group row">
            <div class="input-group col-md-12">
                {{ Form::submit('Darse de baja', ['class' => 'btn btn-danger  center-block']) }}
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>


<div class="modal fade" id="modal-results" tabindex="-1" role="dialog" aria-labelledby="Errores al borrar" aria-hidden="true">
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
                    {{ Session::get('save_success') }}
                </div>
                @endif

                @foreach ($errors->edit_profile->all() as $error)
                <div class="alert alert-danger login-error" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <small>
                        {{ $error }}
                    </small>
                </div>        
                @endforeach

            </div>
        </div>
    </div>
</div>


@stop