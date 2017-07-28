<nav>
    <ul class="primary-header__meta-nav">
        @if (Auth::check())
            <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li><a href="{{ route('bios.index') }}">Bios</a></li>
            <li><a href="{{ route('conferences.index') }}">Conferences</a></li>
            <li><a href="{{ route('talks.index') }}">Talks</a></li>
            <li class="dropdown" role="presentation">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
                    <img src="{{ Auth::user()->profile_picture_thumb }}" class="nav-profile-picture"> Me <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{ route('account.show') }}">Account</a></li>
                    @if (Auth::user()->enable_profile)
                    <li><a href="{{ route('speakers-public.show', [Auth::user()->profile_slug]) }}">Public Speaker Profile</a></li>
                    @endif
                    <li><a href="{{ route('log-out') }}">Log out</a></li>
                </ul>
            </li>
        @else
            <li><a href="{{ url('what-is-this') }}">What is this?</a></li>
            <li><a href="{{ url('speakers') }}">Our speakers</a></li>
            <li><a href="{{ route('conferences.index') }}">Conferences</a></li>
            <li><a href="{{ route('login') }}">Log in</a></li>
            <li><a href="{{ route('register') }}">Sign up</a></li>
        @endif
    </ul>
</nav>
