<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/') }}">E-Review</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/') }}">ER</a>
        </div>
        <ul class="sidebar-menu">
            @if(Auth::user()->isAn('admin'))
                <li class="menu-header">Dashboard</li>
                <li class="{{{ Request::is('dashboard/admin/categories*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                                  href="{{ route('dashboard.admin.category.index') }}"><i
                            class="fa fa-square"></i> <span>Kategori</span></a></li>
                <li class="{{{ Request::is('dashboard/admin/price-list*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                                  href="{{ route('dashboard.admin.price-list.index') }}"><i
                            class="fa fa-money-check"></i> <span>Daftar Harga</span></a></li>
                <li class="{{{ Request::is('dashboard/admin/users*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                             href="{{ route('dashboard.admin.user.index') }}"><i
                            class="fa fa-users"></i> <span>Pengguna</span></a></li>
                <li class="{{{ Request::is('dashboard/admin/settings*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                                href="{{ route('dashboard.admin.setting.index') }}"><i
                            class="fa fa-cogs"></i> <span>Pengaturan</span></a></li>
            @endif
            @if(Auth::user()->isAn('makelar'))
                <li class="menu-header">Dashboard</li>
                <li class="{{{ Request::is('dashboard/makelar/users*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                               href="{{ route('dashboard.makelar.user.index') }}"><i
                            class="fa fa-users"></i> <span>Pengguna</span></a></li>
                <li class="{{{ Request::is('dashboard/makelar/orders*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                                href="{{ route('dashboard.makelar.order.index') }}"><i
                            class="fa fa-money-check"></i> <span>Daftar Transaksi</span></a></li>
                <li class="{{{ Request::is('dashboard/makelar/auctions*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                                  href="{{ route('dashboard.makelar.auction.index') }}"><i
                            class="fa fa-money-check"></i> <span>Daftar Tawaran</span></a></li>
                <li class="{{{ Request::is('dashboard/makelar/withdraw*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                                  href="{{ route('dashboard.makelar.withdraw.index') }}"><i
                            class="fa fa-money-check"></i> <span>Daftar Penarikan</span></a></li>
            @endif
            @if(Auth::user()->isAn('reviewer'))
                <li class="menu-header">Reviewer</li>
                <li class="nav-item dropdown {{{ Request::is('dashboard/reviewer/auctions*') ? 'active' : '' }}}">
                    @if(!is_null(Auth::user()->reviewer_approved_at))
                        <a href="#" class="nav-link has-dropdown"><i class="fa fa-money-check"></i><span>Tawaran</span></a>
                        <ul class="dropdown-menu">
                            <li class="{{{ Request::is('dashboard/reviewer/auctions') || Request::is('dashboard/reviewer/auctions/*') ? 'active' : '' }}}">
                                <a
                                    class="nav-link" href="{{ route('dashboard.reviewer.auction.index') }}">Daftar
                                    Tarawaran</a></li>
                            <li class="{{{ Request::is('dashboard/reviewer/auctions-history') ? 'active' : '' }}}"><a
                                    class="nav-link" href="{{ route('dashboard.reviewer.auction.history') }}">Riwayat
                                    Tawaran</a></li>
                        </ul>
                    @else
                        <a href="#" class="nav-link" id="btn-lock-bid"><i
                                class="fa fa-money-check"></i><span>Tawaran</span><i
                                class="fa fa-lock"></i></a>
                    @endif
                </li>
                <li class="{{{ Request::is('dashboard/reviewer/reviews*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                                  href="{{ route('dashboard.reviewer.review.index') }}"><i
                            class="fa fa-clipboard-list"></i> <span>Daftar Review</span></a></li>
            @endif
            @if(Auth::user()->isAn('editor'))
                <li class="menu-header">Editor</li>
                <li class="{{{ Request::is('dashboard/editor/reviewers*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                                  href="{{ route('dashboard.editor.reviewer.index') }}"><i
                            class="fa fa-users"></i> <span>Daftar Reviewer</span></a></li>
                <li class="{{{ Request::is('dashboard/editor/orders*') ? 'active' : '' }}}"><a class="nav-link"
                                                                                               href="{{ route('dashboard.editor.order.index') }}"><i
                            class="fa fa-money-check"></i> <span>Daftar Transaksi</span></a></li>
            @endif
        </ul>
    </aside>
</div>
