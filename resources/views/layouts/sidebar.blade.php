<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                FT
                <!-- <img class="d-inline-block" width="32px" height="30.61px" src="" alt=""> -->
            </a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header"> - </li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('dashboard') }}">
                    <i class="fas fa-fire"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="dropdown {{ request()->routeIs('product-categories*') ? 'active' : '' }}
                {{ request()->routeIs('product*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-list"></i> <span>Master Product</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('product-categories*') ? 'active' : '' }}">
                        <a href="{{ url('product-categories') }}" class="nav-link">
                            Products-Category
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('products*') ? 'active' : '' }}">
                        <a href="{{ url('products') }}" class="nav-link">
                            Products
                        </a>
                    </li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('users*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-users"></i> <span>Users</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('users*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('pengguna.index') }}">List User</a>
                    </li>
                </ul>
                @if(auth()->user()->hasAccess('spesial'))
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('user-histories*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('user-histories.index') }}">User History</a>
                    </li>
                </ul>
                @endif
            </li>
            <li class="dropdown {{ request()->routeIs('transactions*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-cart-arrow-down"></i> <span>Transaksi</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('payment-methodes*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('payment-methodes.index') }}">Payment Method</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('transactions.index') }}">List Transaksi</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('shippings*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-truck"></i> <span>Pengiriman</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('shippings.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('shippings.index') }}">List Pengiriman</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('report*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-file"></i> <span>Laporan Transaksi</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('report.index.harian') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('report.index.harian') }}">Transaksi Harian</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('report.index.datetodate') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('report.index.datetodate') }}">Transaksi Range Date</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('kotas*') ? 'active' : '' }}
                {{ request()->routeIs('provinsis*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fa fa-map-marker"></i> <span>Master Wilayah</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('provinsis*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('provinsis.index') }}">Provinsi Management</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('kotas*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('kotas.index') }}">Kota Management</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('kecamatans*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('kecamatans.index') }}">Kecamatan Management</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('levels*') ? 'active' : '' }}
                {{ request()->routeIs('roles*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fa fa-gears"></i> <span>Website Modul</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('levels*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('levels.index') }}">Levels Manager</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('roles*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('roles.index') }}">Roles Manager</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('banner-positions*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('banner-positions.index') }}">Banner Positions</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('banners*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('banners.index') }}">Banner</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown {{ request()->routeIs('payment-methodes*') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fa fa-gear"></i> <span>Website Setting</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
