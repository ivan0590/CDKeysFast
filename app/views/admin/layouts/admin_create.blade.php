@extends('admin.layouts.admin')
@section('content')

{{-- Selección de edición --}}
<ul class="nav nav-tabs">
    @foreach($tabs as $resource => $label)
    <li role="presentation" class="{{ $restful === $resource ? 'active' : '' }}">
        {{ HTML::linkRoute("$resource.create", $label) }}
    </li>
    @endforeach
</ul>

{{-- Formulario de creación --}}
<div class="panel panel-default">
    @yield('panel_content')

    <div class="panel-body">
        @foreach($errors->create->all() as $error)
        <div class="alert alert-danger">
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
            {{ $error }}
        </div>
        @endforeach

        @if(Session::get('save_success'))
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
            {{ Session::get('save_success') }}
        </div>
        @endif
    </div>
</div>

@stop