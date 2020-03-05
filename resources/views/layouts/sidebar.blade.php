<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ URL::to('/') }}">
     <div class="sidebar-brand-icon" style="position:relative;">
     <img class="img-profile img-fluid w-50" src="{{ asset('/images/logos/logo-white.png') }}">
      </div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{strpos(url()->current(), 'dashboard') === false ? '' : 'active'}}">
      <a class="nav-link" href="/dashboard">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{strpos(url()->current(), 'timelog') === false ? '' : 'active'}}">
      <a class="nav-link" href="{{ route('timelog.index') }}">
        <i class="fas fa-business-time"></i>
        <span>Timelog</span></a>
    </li>

    <hr class="sidebar-divider">
    
    <li class="nav-item {{strpos(url()->current(), 'deals') === false ? '' : 'active'}}">
      <a class="nav-link" href="{{ route('deals.index')  }}">
        <i class="fas fa-briefcase"></i>
        <span>Deals</span></a>
    </li>
    
    <hr class="sidebar-divider">
      
    <li class="nav-item {{strpos(url()->current(), 'letter') === false ? '' : 'active'}}">
      <a class="nav-link" href="{{ route('letter-templates.index')  }}">
        <i class="fas fa-scroll"></i>
        <span>Letter Template</span></a>
    </li>
    <li class="nav-item {{strpos(url()->current(), 'documents') === false ? '' : 'active'}}">
      <a class="nav-link" href="{{ route('documents.index')  }}">
        <i class="fas fa-folder"></i>
        <span>Documents</span></a>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
  </ul>