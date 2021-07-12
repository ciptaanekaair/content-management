<div class="main-sidebar">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">
                <img class="d-inline-block" width="32px" height="30.61px" src="" alt="">
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
                        <a href="{{ url('product-category') }}" class="nav-link">
                            Products-Category
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('product-categories*') ? 'active' : '' }}">
                        <a href="{{ url('product') }}" class="nav-link">
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
                        <a class="nav-link" href="#">List User</a>
                    </li>
                </ul>
                <ul class="dropdown-menu">
                    <li class="{{ request()->routeIs('users*') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Create User</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
