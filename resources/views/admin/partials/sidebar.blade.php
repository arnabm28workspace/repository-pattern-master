<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <ul class="app-menu">
        <li>
            <a class="app-menu__item  {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-group"></i>
                <span class="app-menu__label">User</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.users.*']) }}"
                    href="{{ route('admin.users.index') }}">
                    <i class="icon fa fa-circle-o"></i>Registered Users
                    </a>
                </li>
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.adminuser']) }}"
                    href="{{ route('admin.adminuser') }}">
                        <i class="icon fa fa-circle-o"></i>All Admins
                        </a>
                </li>
            </ul>
        </li>
        <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-table"></i>
                <span class="app-menu__label">Ads</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.ads.*']) }}"
                    href="{{route('admin.ads.index')}}">
                    <i class="icon fa fa-circle-o"></i>List of Ads
                    </a>
                </li>
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.categories.*']) }}"
                    href="{{ route('admin.categories.index') }}">
                    <i class="icon fa fa-circle-o"></i>Categories
                    </a>
                </li>
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.customform.*']) }}"
                    href="{{ route('admin.customform.index') }}">
                    <i class="icon fa fa-circle-o"></i>Custom Form
                    </a>
                </li>
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.country.*']) }}"
                        href="{{ route('admin.country.index') }}">
                        <i class="icon fa fa-circle-o"></i>Location
                        </a>
                </li>
                <!-- <li>
                    <a class="treeview-item {{ Route::currentRouteName() == 'admin.cities.index' ? 'active' : '' }}"
                        href="{{ route('admin.cities.index') }}">
                        <i class="app-menu__icon fa fa-globe"></i>
                        <span class="app-menu__label">Cities</span>
                    </a>
                </li> -->
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.ads.gallery']) }}"
                        href="{{route('admin.ads.gallery')}}">
                        <i class="icon fa fa-circle-o"></i>Gallery
                        </a>
                </li>
                <!-- <li>
                    <a class="treeview-item {{ Route::currentRouteName() == 'admin.customfield.index' ? 'active' : '' }}"
                        href="{{ route('admin.customfield.index') }}">
                        <i class="app-menu__icon fa fa-list-alt"></i>
                        <span class="app-menu__label">Custom Field</span>
                    </a>
                </li> -->
                <!-- <li>
                    <a class="treeview-item {{ sidebar_open(['admin.ads.getAllAdsMessages']) }}"
                    href="{{route('admin.ads.getAllAdsMessages')}}">
                    <i class="icon fa fa-circle-o"></i>Ads Messages
                    </a>
                </li>
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.ads.getAllAdsReports']) }}"
                    href="{{route('admin.ads.getAllAdsReports')}}">
                    <i class="icon fa fa-circle-o"></i>Reports Against ads
                    </a>
                </li> -->
                <li>
                    <a class="treeview-item {{ sidebar_open(['admin.package.*']) }}"
                        href="{{ route('admin.package.index') }}">
                    <i class="icon fa fa-circle-o"></i>Package
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.pages.*']) }}"
                href="{{ route('admin.pages.index') }}">
                <i class="app-menu__icon fa fa-clone"></i>
                <span class="app-menu__label">Pages</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.payment.*']) }}"
                href="{{ route('admin.payment.index') }}">
                <i class="app-menu__icon fa fa-gbp"></i>
                <span class="app-menu__label">Payment</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item {{ sidebar_open(['admin.settings']) }}"
                href="{{ route('admin.settings') }}"><i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Settings</span>
            </a>
        </li>
        <!-- <li class="treeview">
            <a class="app-menu__item" href="#" data-toggle="treeview">
                <i class="app-menu__icon fa fa-newspaper-o"></i>
                <span class="app-menu__label">Blog</span>
                <i class="treeview-indicator fa fa-angle-right"></i>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a class="treeview-item {{-- Route::currentRouteName() == 'admin.blogs.index' ? 'active' : '' --}}"
                    href="{{-- route('admin.blogs.index') --}}">
                    <i class="icon fa fa-circle-o"></i>Blogs
                    </a>
                </li>
            </ul>
        </li> -->
        <!-- <li>
            <a class="app-menu__item {{ Route::currentRouteName() == 'admin.attribute.index' ? 'active' : '' }}"
                href="{{ route('admin.attribute.index') }}">
                <i class="app-menu__icon fa fa-cogs"></i>
                <span class="app-menu__label">Attribute Management</span>
            </a>
        </li> -->
    </ul>
</aside>