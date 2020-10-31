@if (Auth::check())
    <!-- Left side column. contains the sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
          <div class="pull-left image">
            <img src="{{ backpack_avatar_url(Auth::user()) }}" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <small><small><a href="{{ route('backpack.account.info') }}"><span><i class="fa fa-user-circle-o"></i> {{ trans('backpack::base.my_account') }}</span></a> &nbsp;  &nbsp; <a href="{{ backpack_url('logout') }}"><i class="fa fa-sign-out"></i> <span>{{ trans('backpack::base.logout') }}</span></a></small></small>
          </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          {{-- <li class="header">{{ trans('backpack::base.administration') }}</li> --}}
          <!-- ================================================ -->
          <!-- ==== Recommended place for admin menu items ==== -->
          <!-- ================================================ -->
          <li><a href="{{ backpack_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('backpack::base.dashboard') }}</span></a></li>
          <li class="treeview">
            <a href="#"><i class="fa fa-newspaper-o"></i> <span>Content</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/menu-item') }}"><i class="fa fa-list"></i> <span>Menu</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/page') }}"><i class="fa fa-file-o"></i> <span>Pages</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/banner') }}"><i class="fa fa-file-o"></i> <span>Banners</span></a></li>
              <li class="treeview">
                <a href="#"><i class="fa fa-newspaper-o"></i> <span>News</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/article') }}"><i class="fa fa-newspaper-o"></i> <span>Articles</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/article-category') }}"><i class="fa fa-list"></i> <span>Categories</span></a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#"><i class="fa fa-list"></i> <span>Products</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/product-brand') }}"><i class="fa fa-star"></i> <span>Brands</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/product-category') }}"><i class="fa fa-sitemap"></i> <span>Categories</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/product-family') }}"><i class="fa fa-sitemap"></i> <span>Families</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/product-collection') }}"><i class="fa fa-sitemap"></i> <span>Collections</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/product-style') }}"><i class="fa fa-sitemap"></i> <span>Styles</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/product-tag') }}"><i class="fa fa-tag"></i> <span>Tags</span></a></li>
                  <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/product-item') }}"><i class="fa fa-newspaper-o"></i> <span>Items</span></a></li>
                </ul>
              </li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/elfinder') }}"><i class="fa fa-files-o"></i> <span>File manager</span></a></li>
            </ul>
          </li>
          <!-- Users, Roles Permissions -->
          <li class="treeview">
            <a href="#"><i class="fa fa-group"></i> <span>Users, Roles, Permissions</span> <i class="fa fa-angle-left pull-right"></i></a>
            <ul class="treeview-menu">
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/user') }}"><i class="fa fa-user"></i> <span>Users</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/role') }}"><i class="fa fa-group"></i> <span>Roles</span></a></li>
              <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/permission') }}"><i class="fa fa-key"></i> <span>Permissions</span></a></li>
            </ul>
          </li>
          <li><a href="{{ url(config('backpack.base.route_prefix', 'admin') . '/setting') }}"><i class="fa fa-cog"></i> <span>Settings</span></a></li>


          <!-- ======================================= -->
          {{-- <li class="header">Other menus</li> --}}
        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>
@endif
