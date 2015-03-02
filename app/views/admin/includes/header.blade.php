<nav class="navbar-inverse">
    <div class="container">

        {{-- Logo --}}
        <div class="col-md-4 navbar-left navbar-brand">
            Administración de CDKeysFast
        </div>


        <div class="text-center col-md-4">
            <div class="col-md-12">
                <ul class="nav navbar-nav col-md-12">
                    <li>
                        {{ HTML::linkRoute('admin.product.create', 'Creación') }}
                    </li>

                    <li>
                        {{ HTML::linkRoute('admin.product.index', 'Edición') }}
                    </li>

                    <li>
                        {{ HTML::linkRoute('admin.massive_upload.create', 'Carga masiva') }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-md-4">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    {{ HTML::linkRoute('index', 'Web cliente') }}
                </li>

                <li>
                    {{ Form::open(['route' => ['session.destroy', Auth::id()],
                                        'method' => 'DELETE',
                                        'class' => 'navbar-form']) }}

                    {{ Form::submit('Cerrar sesión', ['class' => 'btn btn-link']) }}
                    {{ Form::close() }}
                </li>
            </ul>
        </div>

    </div>
</nav>
