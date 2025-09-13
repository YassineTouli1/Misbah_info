<style>
    .dashboard-container {
        display: flex;
        margin-top: 70px;
    }

    .sidebar {
        width: 250px;
        background-color: white;
        height: calc(100vh - 70px);
        position: fixed;
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
        padding: 20px 0;
    }

    .sidebar-menu {
        list-style: none;
    }

    .sidebar-menu li {
        margin-bottom: 5px;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        color: var(--dark);
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .sidebar-menu a:hover, .sidebar-menu a.active {
        background-color: var(--light);
        color: var(--primary);
        border-left: 3px solid var(--primary);
    }

    .sidebar-menu i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

</style>
<aside class="sidebar">
    <ul class="sidebar-menu">
        <li><a href="{{route('dashboard.main')}}" class="{{ request()->routeIs('dashboard.main') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> <span>Tableau de bord</span></a></li>
        <li><a href="{{route('dashboard.commandes')}}" class="{{ request()->routeIs('dashboard.commandes') ? 'active' : '' }}"><i class="fas fa-clipboard-list"></i> <span>Commandes</span></a></li>
        <li><a href="{{route('clients')}}" class="{{ request()->routeIs('clients') ? 'active' : '' }}"><i class="fas fa-users"></i> <span>Clients</span></a></li>
        <li><a href="{{route('menus')}}" class="{{ request()->is('menus*') ? 'active' : '' }}"><i class="fas fa-utensils"></i> <span>Menus</span></a></li>
        <li><a href="/stock" class="{{ request()->is('stock*') ? 'active' : '' }}"><i class="fas fa-boxes"></i> <span>stock</span></a></li>
        <li><a href="{{route('manager.caisse')}}" class="{{ request()->routeIs('manager.caisse') ? 'active' : '' }}"><i class="fas fa-money-bill-wave"></i> <span>Caisse</span></a></li>
        <li><a href="{{route('admin.setting.edit')}}" class="{{ request()->routeIs('admin.setting.edit') ? 'active' : '' }}"><i class="fas fa-cog"></i> <span>Settings</span></a></li>
        <li>
            <a href="{{ route('rupture.index') }}" class="{{ request()->routeIs('rupture.index') ? 'active' : '' }}">
                <i class="fas fa-box-open"></i>
                <span>Rupture de Stock</span>
            </a>
        </li>

    </ul>
</aside>
