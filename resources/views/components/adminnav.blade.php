<nav class="uk-navbar-container p-3" uk-navbar style="align-items: center; background: #483434">
    <a href="#offcanvas-nav" style="text-decoration: none; color: white; font-weight: bold; font-size: 20px" uk-toggle><span uk-icon="icon: menu; ratio: 2"></span> Menu</a>
    <form action="{{ url('/logout') }}" method="post" class="ms-auto me-3">
        @csrf
        <button type="submit" class="ms-auto me-3 uk-button uk-button-secondary" style="text-decoration: none; color: white; font-weight: bold; font-size: 20px"><span uk-icon="icon: sign-out; ratio: 2"></span> Logout</button>
    </form>
</nav>

<div id="offcanvas-nav" uk-offcanvas="overlay: true">
    <div class="uk-offcanvas-bar">
        <h1>P. Dhe JJ Coffee</h1>
        <ul class="uk-nav uk-nav-default uk-margin-medium-top">
            {{-- <li class="uk-nav-divider"></li> --}}
            <li class="uk-margin-small-bottom {{ Request::is('admin') ? 'uk-active' : '' }}">
                <a href="{{ url('admin') }}" class="uk-text-large">
                    <span class="uk-margin-small-right" uk-icon="icon: thumbnails"></span> Dashboard
                </a>
            </li>
            <li class="uk-margin-small-bottom {{ Request::is('admin/manage') ? 'uk-active' : '' }}">
                <a href="{{ url('admin/manage') }}" class="uk-text-large">
                    <span class="uk-margin-small-right" uk-icon="icon: file-edit"></span> Kelola Menu
                </a>
            </li>
            <li class="uk-margin-small-bottom {{ Request::is('admin/selling') ? 'uk-active' : '' }}">
                <a href="{{ url('admin/selling') }}" class="uk-text-large">
                    <span class="uk-margin-small-right" uk-icon="icon: cart"></span> Penjualan
                </a>
            </li>
        </ul>
    </div>
</div>