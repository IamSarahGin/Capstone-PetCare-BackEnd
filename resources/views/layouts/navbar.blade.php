<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <ul class="navbar-nav ml-auto">
        <!-- Other navbar items here -->

        <!-- Move the user information and logout button to the end of navbar -->
    </ul>

    <!-- User Information and Logout Button -->
    <div class="d-flex align-items-center">
        <!-- Nav Item - User Information -->
        <span class="mr-2 d-none d-lg-inline text-gray-600 medium">
            Welcome! <span class="user-name">{{ auth()->guard('admin_users')->user()->name }}</span>
        </span>

        <!-- Logout Button -->
        <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

</nav>

<style>
    
    .user-name {
        color: orange; 
        font-weight: bold; 
        font-size: 18px; 
    }
</style>
