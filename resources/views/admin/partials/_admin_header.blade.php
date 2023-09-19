<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        @can('view_notification')
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('admin.notifications.index') }}" title="{{ optional(auth()->user())->unreadNotifications->count() }} @lang('form.notification_unread')">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">{{ optional(auth()->user())->unreadNotifications->count()  }}</span>
                </a>
            </li>
        @endcan
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a href="{{ route('admin.getProfile') }}" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> @lang('form.user.profile')
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.changePassword') }}" class="dropdown-item">
                    <i class="fas fa-key mr-2"></i> @lang('form.user.change_password')
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-sign-out-alt mr-2"></i> @lang('form.logout')
                    </button>
                </form>
            </div>
        </li>
    </ul>
</nav>
