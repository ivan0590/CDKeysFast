<ul class="nav nav-pills nav-justified">
    
    @foreach ($platforms as $platform)
    <li>
        <a href="#platform">
            {{ HTML::image($platform->icon_path, $platform->name) }}
            {{ $platform->name }}
        </a>
    </li>
    @endforeach
</ul>