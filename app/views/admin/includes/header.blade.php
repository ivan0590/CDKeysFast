<nav class="navbar-inverse">
    <div class="container">

        {{-- Logo --}}
        <div class="col-md-4 navbar-left navbar-brand">
            Administración de CDKeysFast
        </div>


        <div class="col-md-6 navbar-right">
            <ul class="nav navbar-nav navbar-right">

                <li>
                    {{ HTML::linkRoute('product.create', 'Creación') }}
                </li>
                
                <li>
                    {{ HTML::linkRoute('product.edition', 'Edición') }}
                </li>

                <li>
                    {{ HTML::linkRoute('import', 'Importar') }}
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
