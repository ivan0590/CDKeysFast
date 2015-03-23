@extends('client.client_layout')
@section('content')
<div>
    {{ HTML::image('img/404.svg', 'Página no encontrada', ['class' => 'img-responsive center-block']) }}
    <div class="alert alert-danger text-center">
        ERROR 404: la página a la que intentas acceder no existe.
    </div>
</div>
@stop