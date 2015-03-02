@extends('admin.layouts.admin')
@section('content')
{{ Form::open(['route' => 'admin.massive_upload.store', 'method' => 'PUT']) }}
<div>
    <div class="form-group">
        <div class="input-group col-md-12">
            {{ Form::label('code', 'Código XML')}}
            {{ Form::textarea('code', null, ['class' => 'form-control col-md-12']) }}
        </div>
    </div>
</div>
<div class="form-group">
    <div class="input-group  col-md-12">
        {{ Form::submit('Cargar', ['class' => 'btn btn-primary  col-md-2 col-md-offset-5']) }}
    </div>
</div>

{{ Form::close() }}

@foreach($errors->update->all() as $error)
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
@stop