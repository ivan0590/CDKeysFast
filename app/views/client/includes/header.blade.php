<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">

        {{-- Logo --}}
        <div class="col-md-4 navbar-btn">
            <div class="navbar-left navbar-link">
                <a href="{{{ URL::route('index') }}}">
                    {{ HTML::image('img/cdkeysfast.svg', 'CDKeysFast', ['class' => 'img-responsive']) }}
                </a>
            </div>
        </div>

        <div class="col-md-4 ">            
            {{-- Busqueda --}}
            {{ Form::open(['route' => ['search.simple'],
                       'method' => 'GET',
                       'class' => 'navbar-form text-center',
                       'role' => 'search']) }} 
            <div class="form-group">

                <div class="input-group">
                    {{ Form::text('ss-name', null, ['placeholder' => 'Buscar productos', 'class' => 'form-control']) }}
                    <div class="input-group-btn btn-group">
                        <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
                        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                {{ HTML::linkRoute('search.advanced', 'Búsqueda avanzada') }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>

        <div class="col-md-4  navbar-right">
            <ul class="nav navbar-nav  navbar-right">

                {{-- Perfil y logout --}}
                @if (Auth::check())
                <li>{{ HTML::linkRoute('user.edit',
                                       Auth::user()->name ?: Auth::user()->email,
                                       Auth::id()) }}</li>
                <li>
                    {{ Form::open(['route' => ['session.destroy', Auth::id()],
                                        'method' => 'DELETE',
                                        'class' => 'navbar-form']) }}

                    {{ Form::submit('Cerrar sesión', ['class' => 'btn btn-link']) }}
                    {{ Form::close() }}
                </li>


                {{-- Registro y login --}}
                @else

                <li class="col-md-4">
                    {{ HTML::linkRoute('user.create', 'Registrarse') }}
                </li>

                <li class="dropdown col-md-8">
                    <a data-placement="bottom" data-toggle="login" data-container="body" class='btn'>Iniciar sesión</a>
                    @include('client.includes.login')
                </li>
                @endif
            </ul>
        </div>

    </div>
</nav>