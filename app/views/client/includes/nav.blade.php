<ul class="nav nav-justified">
    
    @foreach ($platforms as $platform)
    <li class="nav-pills">
        <a href="{{{ URL::route('platform.show', ['id' => $platform->id]) }}}" >
            {{ HTML::image($platform->icon_path, $platform->name, ['class' => 'platform-image svg']) }}
            {{ Form::label(null, $platform->name, ['class' => 'vertical-align font-'.(strtolower(str_replace(' ', '', $platform->name)))]) }}
        </a>
    </li>
    @endforeach
</ul>