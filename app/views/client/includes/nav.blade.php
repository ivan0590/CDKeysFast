<div id="platforms-header" class="navbar-header hidden-sm hidden-md hidden-lg  col-xs-12">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-platforms" aria-expanded="false" aria-controls="navbar-platforms">
        <span class="sr-only">Plataformas</span>
        <span class="glyphicon glyphicon-chevron-down"></span>
    </button>

    <span class="navbar-brand hidden-sm hidden-md hidden-lg">
        Plataformas
    </span>
</div>
<ul id="navbar-platforms" class="nav nav-justified navbar-collapse collapse">

    @foreach ($platforms as $platform)
    <li class="nav-pills">
        <a href="{{{ URL::route('platform.show', ['id' => $platform->id]) }}}" class="hidden-sm" >
            {{ HTML::image($platform->icon_path, $platform->name, ['class' => 'platform-image svg']) }}
            {{ Form::label(null, $platform->name, ['class' => 'vertical-align font-'.(strtolower(str_replace(' ', '', $platform->name)))]) }}
        </a>
        <a href="{{{ URL::route('platform.show', ['id' => $platform->id]) }}}" class="hidden-xs hidden-md hidden-lg" >
            {{ Form::label(null, $platform->name, ['class' => 'font-'.(strtolower(str_replace(' ', '', $platform->name)))]) }}
        </a>
    </li>
    @endforeach
</ul>
<div class="clearfix"></div>