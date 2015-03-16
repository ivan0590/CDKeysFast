<!DOCTYPE html>
<html>
    <head>
        @include('admin.includes.head')
    </head>

    <body>
        <div class="container">

            <div class="col-md-12">
                {{ Form::open(['action' => 'session.store', 'class' => 'col-md-4 col-md-offset-4']) }}

                <div class="form-group ">
                    <div class="form-group">
                        <div class="input-group col-md-8">
                            {{ Form::label('Email')}}
                            {{ Form::text('email', null, ['class' => 'form-control col-md-10 col-md-offset-1','placeholder' => 'Email']) }}
                        </div>
                        <div class="input-group col-md-8">
                            {{ Form::label('Password')}}
                            {{ Form::password('password', ['class' => 'form-control col-md-10 col-md-offset-1', 'placeholder' => 'Contraseña']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group col-md-8">
                            {{ Form::submit('Login', ['class' => 'btn btn-primary col-md-4 col-md-offset-5']) }}
                        </div>
                    </div>
                </div>

                <div class="col-md-9">
                        @foreach ($errors->login->all() as $key => $error)
                        <div class="alert alert-danger login-error col-md-12" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <small>
                                {{{ $error }}}
                                @if($errors->login->get('userNotConfirmed') === [$error])
                                {{ HTML::linkAction('send_verify', 'Volver a enviar email de confirmación', Input::old('email')) }}
                                @endif
                            </small>
                        </div>        
                        @endforeach
                </div>

                {{ Form::close() }}
            </div>
        </div>
    </body>
</html>
