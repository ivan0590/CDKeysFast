<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            {{ Form::label('name', 'Nombre')}}
        </div>
        {{ Form::text('name', null, ['class' => 'form-control']) }}
    </div>
</div>

<div class="form-group">
    <div class="input-group">
        <div class="input-group-addon">
            {{ Form::label('description', 'Descripción')}}
        </div>
        {{ Form::textarea('description', null, ['class' => 'form-control']) }}
    </div>
</div>