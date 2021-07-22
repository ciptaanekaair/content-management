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
                    <li class="{{ request()->routeIs('transactions.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('transactions.index') }}">List Transaksi</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('transactions.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('transactions.create') }}">New Transaksi</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-file"></i> <span>Laporan Transaksi</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="">
                        <a class="nav-link" href="{{ route('transactions.index') }}">Transaksi Harian</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="">
                        <a class="nav-link" href="{{ route('transactions.index') }}">Transaksi Bulanan</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="">
                        <a class="nav-link" href="{{ route('transactions.index') }}">Transaksi Tahunan</a>
                    </li>
                </ul>
            </li>
            <li class="dropdown ">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown">
                    <i class="fas fa-cart-arrow-down"></i> <span>Transaksi</span>
                </a>
                <ul class="dropdown-menu">
                    <li class="">
                        <a class="nav-link" href="{{ route('transactions.index') }}">List Transaksi</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="">
                        <a class="nav-link" href="#">New Transaksi</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
