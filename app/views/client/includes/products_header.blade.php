<div class="navbar navbar-default">

    <div class="navbar-collapse navbar-header">
        <h3>{{ $title }}</h3>
    </div>
    <div class="navbar-collapse navbar-right">
        {{ Form::open(['class' => 'navbar-form']) }}
        <div class="form-group">
            <select class="form-control" id="sorter" >
                <option disabled selected>Ordenar por</option>
                <option value="{{ URL::route('index') }}/price-asc">Precio ascendente</option>
                <option value="{{ URL::route('index') }}/price-desc">Precio descendente</option>
                <option value="{{ URL::route('index') }}/name-asc">Nombre A-Z</option>
                <option value="{{ URL::route('index') }}/name-desc">Nombre Z-A</option>
            </select>
        </div>
        {{ Form::close() }}
    </div>
</div>