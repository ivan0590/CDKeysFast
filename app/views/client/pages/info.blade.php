@extends('client.layouts.client')
@section('content')
<div>
    @foreach($errors->confirm->all() as $error)
    <div class="alert alert-warning">
        <span class="glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
        {{ $error }}
    </div>
    @endforeach
    
    @if($message)
    <div class="alert alert-success">
        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
        {{ $message }}
    </div>
    @endif
    
</div>
@stop