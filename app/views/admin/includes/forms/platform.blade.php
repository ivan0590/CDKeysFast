<div class="col-md-6">
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
</div>
<div class="col-md-6">
    @if(isset($model) && $model->icon_path !== null)
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon ">
                {{ Form::label('icon_path', 'Icono actual')}}
            </div>

            <div class="panel panel-default modal-title">
                <div class="panel-body">
                    {{ HTML::image($model->icon_path, 'Icono', ['class' => 'center-block img-responsive']) }}
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('icon_path', 'Subir icono')}}
            </div>
            {{ Form::file('icon_path', ['class' => 'form-control']) }}
        </div>
    </div>
</div>