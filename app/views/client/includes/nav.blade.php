<ul class="nav nav-justified">
    
    @foreach ($platforms as $platform)
    <li class="nav-pills">
        <a href="{{ URL::route('platform.show', ['id' => $platform->id]) }}" >
            {{ HTML::image($platform->icon_path, $platform->name) }}
            {{ Form::label(null, $platform->name, ['class' => 'btn']) }}
        </a>
    </li>
    @endforeach
</ul>