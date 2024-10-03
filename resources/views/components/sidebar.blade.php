<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="index.html" class="app-brand-link">
        <img src="{{asset('assets/myimg/logo.png')}}" class="app-brand-logo w-px-30 h-auto me-2 " alt="logo" />
            <span class="app-brand-text menu-text fw-bold">BUGS
              <br />
              <span class="fs-tiny fw-medium">Honorarium Monitoring System</span>
            </span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
        <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Page -->
        @if(Auth::user()->usertype->name !== 'Faculties')
        <li class="menu-item {{ request()->is('admin_dashboard') ? 'active' : '' }}">
          <a href="/admin_dashboard" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div class="text-truncate" data-i18n="Page 1">Dashboard</div>
          </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name === 'Faculties')
        <li class="menu-item {{ request()->is('faculty_dashboard') ? 'active' : '' }}">
            <a href="/faculty_dashboard" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div class="text-truncate" data-i18n="Page 1">Faculty Dashboard</div>
            </a>
          </li>
        @endif
        <li class="menu-item {{ request()->is('admin_email') ? 'active' : '' }}">
          <a href="/admin_email" class="menu-link">
            <i class='menu-icon tf-icons bx bx-envelope'></i>
            <div class="text-truncate" data-i18n="Page 2">Inbox</div>
            <span class="badge bg-danger badge-notifications p-1 fs-8">{{$EmailCount ?? 0}}</span>
          </a>
        </li>
        <li class="menu-item {{ request()->is('sent_items') ? 'active' : '' }}">
            <a href="/sent_items" class="menu-link">
              <i class='menu-icon tf-icons bx bx-send'></i>
              <div class="text-truncate" data-i18n="Page 2">Sent Items</div>
            </a>
        </li>

        <li class="menu-item">
          <div style="margin-left: 5%; margin-top: 5%; color: #b4b0c4;">Transaction</div>
        </li>

        @if(Auth::user()->usertype->name === 'Admin' || Auth::user()->usertype->name === 'Superadmin')
        <li class="menu-item {{ request()->is('admin_honorarium') ? 'active' : '' }}">
            <a href="/admin_honorarium" class="menu-link">
              <i class='menu-icon tf-icons bx bx-list-plus'></i>
              <div class="text-truncate" data-i18n="Page 2">Honorarium</div>
            </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name === 'Admin' || Auth::user()->usertype->name === 'Superadmin')
        <li class="menu-item {{ request()->is('admin_new_entries') ? 'active' : '' }}">
          <a href="/admin_new_entries" class="menu-link">
            <i class='menu-icon tf-icons bx bx-plus-circle'></i>
            <div class="text-truncate" data-i18n="Page 2">New Entries</div>
          </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name !== 'Admin' && Auth::user()->usertype->name !== 'Faculties')
        <li class="menu-item {{ request()->is('for_acknowledgement') ? 'active' : '' }}">
          <a href="/for_acknowledgement" class="menu-link">
            <i class='menu-icon tf-icons bx bx-archive-in'></i>
            <div class="text-truncate" data-i18n="Page 2">Acknowledgement</div>
            <span class="badge bg-danger badge-notifications p-1 fs-8">{{$TransactionCount ?? 0}}</span>
          </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name !== 'Faculties' && Auth::user()->usertype->name !== 'Cashiers')
        <li class="menu-item {{ request()->is('admin_on_queue') ? 'active' : '' }}">
          <a href="/admin_on_queue" class="menu-link">
            <i class='menu-icon tf-icons bx bx-list-ol'></i>
            <div class="text-truncate" data-i18n="Page 2">In Queue</div>
          </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name === 'Cashiers')
        <li class="menu-item {{ request()->is('cashier_in_queue') || request()->is('cashier_open_queue') ? 'active' : '' }}">
          <a href="/cashier_in_queue" class="menu-link">
            <i class='menu-icon tf-icons bx bx-list-ol'></i>
            <div class="text-truncate" data-i18n="Page 2">Cashier In Queue</div>
          </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name !== 'Faculties')
        <li class="menu-item {{ request()->is('admin_on_hold') ? 'active' : '' }}">
          <a href="/admin_on_hold" class="menu-link">
            <i class='menu-icon tf-icons bx bx-error-alt'></i>
            <div class="text-truncate" data-i18n="Page 2">On Hold</div>
          </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name === 'Faculties')
        <li class="menu-item {{ request()->is('faculty_tracking') ? 'active' : '' }}">
          <a href="/faculty_tracking" class="menu-link">
            <i class='menu-icon tf-icons bx bx-tag-alt'></i>
            <div class="text-truncate" data-i18n="Page 2">Track & Monitor</div>
          </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name !== 'Faculties')
        <li class="menu-item {{ request()->is('history') ? 'active' : '' }}">
          <a href="/history" class="menu-link">
            <i class='menu-icon tf-icons bx bx-history' ></i>
            <div class="text-truncate" data-i18n="Page 2">History</div>
          </a>
        </li>
        @endif
        @if(Auth::user()->usertype->name === 'Admin' || Auth::user()->usertype->name === 'Superadmin')
        <li class="menu-item">
            <div style="margin-left: 5%; margin-top: 5%; color: #b4b0c4;">Users</div>
        </li>


        <li class="menu-item {{ request()->is('user_management') ? 'active' : '' }}">
            <a href="/user_management" class="menu-link">
              <i class='menu-icon tf-icons bx bx-shield-alt-2'></i>
              <div class="text-truncate" data-i18n="Page 2">User Management</div>
            </a>
        </li>



        <li class="menu-item {{ request()->is('admin_faculty') || request()->is('admin_view_faculty') ? 'active' : '' }}">
          <a href="/admin_faculty" class="menu-link">
            <i class='menu-icon tf-icons bx bx-group'></i>
            <div class="text-truncate" data-i18n="Page 2">Faculties</div>
          </a>
        </li>
        @endif
      </ul>
  </aside>
