@extends('client.layouts.client')
@section('content')
<div class="panel panel-default">

    {{-- Cabecera --}}
    <div class="panel-heading clearfix">
        <h3 class="navbar-text">Editar perfil</h3>
    </div>

    <div class="panel-body">

        {{-- Cambiar email --}}
        <div class="panel col-md-6">
            <div class="panel-body">

                <h4>Cambiar email</h4>

                {{ Form::open(['route' => ['update_email', Auth::id()],
                               'method' => 'POST']) }}
                <div class="form-group col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('email', 'Email')}}
                            </div>
                            {{ Form::text('email', Auth::user()->email, ['class' => 'form-control']) }}
                        </div>

                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('email_confirmation', 'Repetir email')}}
                            </div>
                            {{ Form::text('email_confirmation', null, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div>
                        @foreach ($errors->email->all() as $key => $error)
                        <div class="alert alert-danger login-error" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <small>
                                {{ $error }}
                            </small>
                        </div>        
                        @endforeach

                        @if(Session::get('email_success'))
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            {{ Session::get('email_success') }}
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            {{ Form::submit('Guardar', ['class' => 'btn btn-success  col-md-4 col-md-offset-4']) }}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        {{-- Cambiar contraseña --}}
        <div class="panel col-md-6">
            <div class="panel-body">

                <h4>Cambiar contraseña</h4>

                {{ Form::open(['route' => ['update_password', Auth::id()],
                               'method' => 'POST']) }}
                <div class="form-group col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('password', 'Password')}}
                            </div>
                            {{ Form::password('password', ['class' => 'form-control']) }}
                        </div>

                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('password_confirmation', 'Repetir password')}}
                            </div>
                            {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div>
                        @foreach ($errors->password->all() as $key => $error)
                        <div class="alert alert-danger login-error" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <small>
                                {{ $error }}
                            </small>
                        </div>        
                        @endforeach

                        @if(Session::get('password_success'))
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                            {{ Session::get('password_success') }}
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            {{ Form::submit('Guardar', ['class' => 'btn btn-success  col-md-4 col-md-offset-4']) }}
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        {{-- Cambiar datos personales --}}
        <div class="panel">
            <div class="panel-body col-md-12">

                <h4>Cambiar datos personales</h4>

                {{ Form::open(['route' => ['update_personal', Auth::id()],
                               'method' => 'POST'])  }}
                <div class="form-group row">

                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('name', 'Nombre')}}
                            </div>
                            {{ Form::text('name',  Auth::user()->name, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('surname', 'Apellidos')}}
                            </div>
                            {{ Form::text('surname',  Auth::user()->surname, ['class' => 'form-control']) }}
                        </div>
                    </div>

                    @if(Auth::user()->userable_type !== 'Admin')
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('birthdate', 'Fecha de nacimiento') }}
                            </div>
                            {{ Form::input('date', 'birthdate', Auth::user()->userable->birthdate, ['min' => '1930-01-01', 'max' => date('Y-m-d'), 'class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('dni', 'DNI')}}
                            </div>
                            {{ Form::text('dni', Auth::user()->userable->dni, ['class' => 'form-control']) }}
                        </div>
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <div class="input-group col-md-12">
                        {{ Form::submit('Guardar', ['class' => 'btn btn-success  col-md-2 col-md-offset-5']) }}
                    </div>

                </div>

                <div>
                    @foreach ($errors->personal->all() as $key => $error)
                    <div class="alert alert-danger login-error" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <small>
                            {{ $error }}
                        </small>
                    </div>        
                    @endforeach

                    @if(Session::get('personal_success'))
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        {{ Session::get('personal_success') }}
                    </div>
                    @endif
                </div>
                {{ Form::close() }}
            </div>
        </div>

        {{-- Darse de baja --}}
        <div class="panel">
            <div class="panel-body col-md-12">

                <h4>Darse de baja</h4>

                {{ Form::open(['route' => ['unsuscribe', Auth::id()],
                               'method' => 'POST'])  }}

                <div class="form-group">
                    <div class="input-group col-md-12">
                        {{ Form::submit('Enviar email de confirmación', ['class' => 'btn btn-danger  col-md-4 col-md-offset-4']) }}
                    </div>
                </div>

                <div>
                    @foreach ($errors->unsuscribe->all() as $key => $error)
                    <div class="alert alert-danger login-error" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <small>
                            {{ $error }}
                        </small>
                    </div>        
                    @endforeach

                    @if(Session::get('unsuscribe_success'))
                    <div class="alert alert-success">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        {{ Session::get('unsuscribe_success') }}
                    </div>
                    @endif
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop