@extends('client.layouts.client')
@section('content')
<div>
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger login-error" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
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