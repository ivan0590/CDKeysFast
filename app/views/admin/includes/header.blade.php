<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">

        {{-- Logo --}}
        <div class="col-md-4 navbar-left navbar-brand">
            Administración de CDKeysFast
        </div>

        <div class="col-md-6 navbar-right">
            <ul class="nav navbar-nav pull-right">
                <li>
                    {{ HTML::linkRoute('admin.product.index', 'Edición') }}
                </li>

                <li>
                    {{ HTML::linkRoute('admin.massive_upload.create', 'Carga masiva') }}
                </li>
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
