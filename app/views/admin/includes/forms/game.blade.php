<div class="col-md-6">
    <div class="form-group">

        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('name', 'Nombre')}}
            </div>
            {{ Form::text('name', null, ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        {{ Form::label('category_id', 'Categoría')}}
                    </div>
                    {{ Form::select('category_id', $categories, null, ['class' => 'form-control']) }}
                </div>               
            </div>  
        </div>  
        <div class="col-md-6">

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-addon">
                        {{ Form::label('agerate_id', 'Calificación')}}
                    </div>
                    {{ Form::select('agerate_id', $agerates, null, ['class' => 'form-control']) }}
                </div>                
            </div>                        
        </div>                        
    </div>                        
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('thumbnail_image_path', 'Imagen para miniaturas')}}
            </div>
            {{ Form::file('thumbnail_image_path', ['class' => 'form-control']) }}
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('offer_image_path', 'Imagen para ofertas')}}
            </div>
            {{ Form::file('offer_image_path', ['class' => 'form-control']) }}
        </div>
    </div>
    @if(isset($model) && $model->thumbnail_image_path !== null)
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon ">
                {{ Form::label('thumbnail_image_path', 'Miniatura actual')}}
            </div>

            <div class="panel panel-default modal-title">
                <div class="panel-body">
                    {{ HTML::image($model->thumbnail_image_path, 'Icono', ['class' => 'center-block img-responsive']) }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="col-md-6">

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon">
                {{ Form::label('description', 'Descripción')}}
            </div>
            {{ Form::textarea('description', null, ['class' => 'form-control']) }}
        </div>
    </div>
    @if(isset($model) && $model->offer_image_path !== null)
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon ">
                {{ Form::label('offer_image_path', 'Oferta actual')}}
            </div>

            <div class="panel panel-default modal-title">
                <div class="panel-body">
                    {{ HTML::image($model->offer_image_path, 'Icono', ['class' => 'center-block img-responsive']) }}
                </div>
            </div>
        </div>
    </div>
    @endif
</div>