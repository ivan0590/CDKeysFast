<nav class="navbar navbar-default">
    <div class="container-fluid">

        <!-- Logo -->
        <div class="navbar-header">
            <a class="navbar-brand" href="#index">
                {{ HTML::image('img/cdkeysfast.svg'); }}
            </a>
        </div>

        <!-- Busqueda -->
        {{ Form::open() }} 
        <div class="navbar-form navbar-left">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Buscar productos">
                <a href="#advanced_search"><small>Busqueda avanzada</small></a>
            </div>
        </div>
        {{ Form::close() }}

        @if (Auth::check()) <!-- Perfil y logout -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#edit">{{Auth::user()->name}}</a></li>
                <li>
                    {{ Form::open(['route' => ['session.destroy', Auth::id()],
                                        'method' => 'DELETE',
                                        'class' => 'navbar-form',
                                        'role' => 'logout']) }}

                    {{ Form::submit('Cerrar sesión', ['class' => 'btn btn-link']) }}
                    {{ Form::close() }}
                </li>
            </ul>
        </div>

        @else <!-- Registro y login -->
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">

                <!-- Registro -->
                <li><a href="#register">Registrarse</a></li>

                <!-- Inicio de sesión -->
                <li class="dropdown">
                    <a data-placement="bottom" data-toggle="login" data-container="body">Iniciar sesión</a>
                    @include('client.includes.login')
                </li>
            </ul>
        </div>
        @endif
    </div>
</nav>
