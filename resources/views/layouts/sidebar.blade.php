<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div>
        <img src="{{ asset('petcareLogo.ico') }}" class="img-fluid" alt="Logo" width="60">
    </div>
    <div class="sidebar-brand-text mx-3" >PetCare Admin</div>
</a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
                <a class="nav-link" href="{{route('dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('admin.bookings') }}">
                <i class="fas fa-fw fa-cog"></i>
                    <span>Pending Booking</span></a>
            </li>
            <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.bookings.approved') }}">
            <i class="fas fa-fw fa-cog"></i>
                <span>Approved Bookings</span>
            </a>
            </li>
            <li class="nav-item ">
            <a class="nav-link" href="{{ route('admin.bookings.rejected') }}">
            <i class="fas fa-fw fa-cog"></i>
                <span>Rejected Bookings</span>
            </a>
            </li>

          <!-- Nav Item - Services -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.services') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Service Management</span>
                </a>
            </li>


          

           
            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

           

        </ul>

