<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">{{ auth()->user()->role }}</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('dashboard') }}">{{ auth()->user()->role }}</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><a class="nav-link"
                    href="{{ route('dashboard') }}"><i class="fas fa-fire"></i><span>Dashboard</span></a></li>
            <li class="menu-header">Starter</li>
            <li
                class="{{ request()->routeIs('group.index') || request()->routeIs('group.create') || request()->routeIs('group.show') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('group.index') }}"><i
                        class="far fa-solid fa-user-group"></i><span>Group</span></a>
            </li>
        </ul>
    </aside>
</div>
