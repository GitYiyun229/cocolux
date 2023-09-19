<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.home') }}" class="brand-link">
        <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">@lang('form.final_style')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ auth()->user()->name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item @if (request()->is('admin/users*') || request()->is('admin/role*')) menu-open @endif">
                    <a href="#" class="nav-link @if (request()->is('admin/users*') || request()->is('admin/role*')) active @endif">
                        <i class="fas fa-user"></i>
                        <p>
                            @lang('form.user.title')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link @if (request()->is('admin/users*')) active @endif">
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    @lang('form.user.')
                                </p>
                            </a>
                        </li>
                        @can('view_role')
                            <li class="nav-item">
                                <a href="{{ route('admin.roles.index') }}" class="nav-link @if (request()->is('admin/role*')) active @endif">
                                    <i class="nav-icon far fa-plus-square" aria-hidden="true"></i>
                                    <p>
                                        @lang('form.roles.')
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
                @can(['view_page'])
                    <li class="nav-item">
                        <a href="{{ route('admin.page.index') }}" class="nav-link @if (request()->is('admin/page*')) active @endif">
                            <i class="nav-icon fas fa-pager"></i>
                            <p>
                                @lang('form.page.')
                            </p>
                        </a>
                    </li>
                @endcan
                @can('view_article')
                    <li class="nav-item @if (request()->is('admin/article*')) menu-open @endif">
                        <a href="#" class="nav-link @if (request()->is('admin/article*')) active @endif">
                            <i class="fas fa-newspaper"></i>
                            <p>
                                @lang('form.article.')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.article-category.index') }}" class="nav-link @if (request()->is('admin/article-category*')) active @endif">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>
                                        @lang('form.article_category.')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.article.index') }}" class="nav-link @if (request()->is('admin/articles*')) active @endif">
                                    <i class="nav-icon fas fa-newspaper"></i>
                                    <p>
                                        @lang('form.article.')
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('view_product')
                    <li class="nav-item @if (request()->is('admin/product*')) menu-open @endif">
                        <a href="#" class="nav-link @if (request()->is('admin/product*')) active @endif">
                            <i class="fab fa-product-hunt"></i>
                            <p>
                                @lang('form.product.')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.product-category.index') }}" class="nav-link @if (request()->is('admin/product-category*')) active @endif">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>
                                        @lang('form.product_category.')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.product.index') }}" class="nav-link @if (request()->is('admin/product')) active @endif">
                                    <i class="nav-icon fab fa-product-hunt"></i>
                                    <p>
                                        @lang('form.product.')
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('view_menu')
                    <li class="nav-item @if (request()->is('admin/menu*')) menu-open @endif">
                        <a href="#" class="nav-link @if (request()->is('admin/menu*')) active @endif">
                            <i class="fab fa-mendeley"></i>
                            <p>
                                @lang('form.menu.')
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.menu-category.index') }}" class="nav-link @if (request()->is('admin/menu-category')) active @endif">
                                    <i class="nav-icon fas fa-layer-group"></i>
                                    <p>
                                        @lang('form.menu_category.')
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.menu.index') }}" class="nav-link @if (request()->is('admin/menu')) active @endif">
                                    <i class="nav-icon fab fa-mendeley"></i>
                                    <p>
                                        @lang('form.menu.')
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can(['view_setting'])
                    <li class="nav-item">
                        <a href="{{ route('admin.setting.index') }}" class="nav-link @if (request()->is('admin/setting*')) active @endif">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                @lang('form.setting.')
                            </p>
                        </a>
                    </li>
                @endcan
                @can(['view_contact'])
                <li class="nav-item">
                    <a href="{{ route('admin.contact.index') }}" class="nav-link @if (request()->is('admin/contact')) active @endif">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            @lang('form.contact.')
                        </p>
                    </a>
                </li>
                @endcan
                @can(['view_book_table'])
                    <li class="nav-item">
                        <a href="{{ route('admin.book-table.index') }}" class="nav-link @if (request()->is('admin/book-table')) active @endif">
                            <i class="nav-icon fas fa-book-reader"></i>
                            <p>
                                @lang('form.book_table.')
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item @if (request()->is('admin/media*') || request()->is('admin/media*')) menu-open @endif">
                    <a href="#" class="nav-link @if (request()->is('admin/media*') || request()->is('admin/media*')) active @endif">
                        <i class="fas fa-photo-video"></i>
                        <p>
                            @lang('form.media.')
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can(['view_media_image'])
                            <li class="nav-item">
                                <a href="{{ route('admin.media-image.index') }}" class="nav-link @if (request()->is('admin/media-image*')) active @endif">
                                    <i class="nav-icon fas fa-images"></i>
                                    <p>
                                        @lang('form.media._image')
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can(['view_media_video'])
                            <li class="nav-item">
                                <a href="{{ route('admin.media-video.index') }}" class="nav-link @if (request()->is('admin/media-video*')) active @endif">
                                    <i class="nav-icon fas fa-video"></i>
                                    <p>
                                        @lang('form.media._video')
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @can(['view_product_orders'])
                    <li class="nav-item">
                        <a href="{{ route('admin.order-product.index') }}" class="nav-link @if (request()->is('admin/order-product')) active @endif">
                            <i class="nav-icon fas fa-scroll"></i>
                            <p>
                                @lang('form.order-product.')
                            </p>
                        </a>
                    </li>
                @endcan
                @can(['view_slider'])
                    <li class="nav-item">
                        <a href="{{ route('admin.slider.index') }}" class="nav-link @if (request()->is('admin/slider')) active @endif">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>
                                @lang('form.slider.')
                            </p>
                        </a>
                    </li>
                @endcan
                @can(['view_store'])
                    <li class="nav-item">
                        <a href="{{ route('admin.store.index') }}" class="nav-link @if (request()->is('admin/store')) active @endif">
                            <i class="nav-icon fas fa-store"></i>
                            <p>
                                @lang('form.store.')
                            </p>
                        </a>
                    </li>
                @endcan
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
