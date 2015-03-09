@extends('client.layouts.client')
@section('content')
<div>
    <div class="panel panel-default">

        {{-- Cabecera --}}
        <div class="panel-heading clearfix">
            <h3 class="navbar-text">Crear una nueva cuenta de CDKeysFast</h3>
        </div>

        <div class="panel-body">
            <div class="col-md-12">

                {{ Form::open(['action' => 'user.store', 'method' => 'POST']) }}

                <div class="form-group col-md-4 col-md-offset-4">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('email', 'Email')}}
                            </div>
                            {{ Form::text('email', null, ['class' => 'form-control']) }}
                        </div>
                        <div class="input-group">
                            <div class="input-group-addon">
                                {{ Form::label('email_confirmation', 'Repetir email')}}
                            </div>
                            {{ Form::text('email_confirmation', null, ['class' => 'form-control']) }}
                        </div>
                    </div>
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

                    <div class="form-group">
                        <div class="alert alert-info h6">
                            Al crear una cuenta, acepto las Condiciones de Servicio y la Política de Privacidad de CDKeysFast.            
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-12">
                            {{ Form::submit('Registrarse', ['class' => 'btn btn-primary  center-block']) }}
                        </div>
                    </div>

                </div>

                <div class="col-md-4">
                    @foreach ($errors->register->all() as $error)
                    <div class="alert alert-danger h6" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        {{ $error }}
                    </div>        
                    @endforeach
                </div>

                {{ Form::close() }}

            </div>
        </div>
    </div>


</div>
@stop