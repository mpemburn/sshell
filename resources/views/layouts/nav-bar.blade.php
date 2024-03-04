<li class="nav-item">
    <a class="nav-link @if(Route::currentRouteName() == 'shell') active @endif" href="{{ route('shell') }}">Shell</a>
</li>
<li class="nav-item">
    <a class="nav-link @if(Route::currentRouteName() == 'script_edit') active @endif" href="{{ route('script_edit') }}">Script Editor</a>
</li>
<li class="nav-item">
    <a class="nav-link @if(Route::currentRouteName() == 'modifier_edit') active @endif" href="{{ route('modifier_edit') }}">Modifier Editor</a>
</li>
