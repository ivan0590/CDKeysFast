@extends('client.layouts.client')
@section('content')
<div>
    <div>        
        <h3>Crear una nueva cuenta de CDKeysFast</h3>
    </div>

    {{ Form::open(['action' => 'user.store', 'method' => 'POST', 'role' => 'register']) }}

    <div class="form-group col-md-4 col-md-offset-4">
        <div class="form-group">
            <div class="input-group ">
                <div class="input-group-addon">
                    {{ Form::label('email', 'Email')}}
                </div>
                {{ Form::text('email', null, ['class' => 'form-control']) }}
            </div>
            <div class="input-group ">
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
            <div class="alert alert-info">
                <small>
                    Al crear una cuenta, acepto las Condiciones de Servicio y la Política de Privacidad de CDKeysFast.            
                </small>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group  col-md-12">
                {{ Form::submit('Registrarse', ['class' => 'btn btn-primary  col-md-4 col-md-offset-4']) }}
            </div>
        </div>

    </div>
    
    <div class="col-md-4">
        @foreach ($errors->register->all() as $error)
        <div class="alert alert-danger" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <small>{{ $error }}</small>
        </div>        
        @endforeach
    </div>

    {{ Form::close() }}
</div>
@stop