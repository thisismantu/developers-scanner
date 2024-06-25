<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}">
                <i class="bi bi-grid"></i>
                <span>{{ __('Dashboard') }}</span>
            </x-responsive-nav-link>
        </li>
        @if (Auth::user()->is_admin == 1)
            <li class="nav-item">
                <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies')"
                    class="nav-link {{ request()->routeIs('companies') ? '' : 'collapsed' }}">
                    <i class="bi bi-bank"></i>
                    <span>{{ __('Companies') }}</span>
                </x-responsive-nav-link>
            </li>
        @endif
        <li class="nav-item">
            <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects')"
                class="nav-link {{ request()->routeIs('projects') ? '' : 'active collapsed' }}">
                <i class="bi bi-layout-text-window-reverse"></i>
                <span>{{ __('Projects') }}</span>
            </x-responsive-nav-link>
        </li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#users" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Manage Users</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users" class="nav-content collapse {{ request()->segment(1) == 'manage' ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('users.index') }}" class="{{ request()->segment(2) == 'users' ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>{{ __('Users') }}</span>
                    </a>
                </li>
                @if (Auth::user()->is_admin == 1)
                    <li>
                        <a href="{{ Route('projectMapping') }}"
                            class="{{ request()->segment(2) == 'project-mapping' ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>{{ __('Project Mapping') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>


        <li class="nav-item">
            <x-responsive-nav-link :href="route('logout')" class="nav-link collapsed"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> <i
                    class="bi bi-box-arrow-in-right"></i>
                <span>{{ __('Log out') }}</span>
            </x-responsive-nav-link>

        </li>
    </ul>
</aside>
