<div class="dropdown-menu" id="login">
    {{ Form::open(['action' => 'session.store', 'role' => 'login']); }}

    <div class="form-group">
        <div class="form-group">
            <div class="input-group">
                {{ Form::label('Email')}}
                {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']); }}
            </div>
            <div class="input-group">
                {{ Form::label('Password')}}
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña']); }}
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                {{ Form::submit('Login', ['class' => 'btn btn-primary ']); }}
            </div>
        </div>
    </div>

    <div>
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger login-error" role="alert">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            <small>{{ $error }}</small>
        </div>        
        @endforeach
    </div>

    {{ Form::close(); }}
</div>