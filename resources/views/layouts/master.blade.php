<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard') | Sunface Technologies</title>

  <!-- Bootstrap CSS & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

  <style>
    :root {
      --header-height: 60px;
      --sidebar-width: 240px;
    }

    * {
      box-sizing: border-box;
    }

    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
      font-family: 'Segoe UI', sans-serif;
    }

    #header {
      height: var(--header-height);
      width: 100%;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1040;
      background-color: #f6f6f6;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 1rem;
      color: white;
      border-bottom: 1px solid #6c757d;
    }

    #header .navbar-brand img {
      height: 40px;
    }

    #sidebar {
      position: fixed;
      top: var(--header-height);
      left: 0;
      width: var(--sidebar-width);
      height: calc(100% - var(--header-height));
      background: #212529;
      border-right: 1px solid #dee2e6;
      overflow-y: auto;
      z-index: 1030;
      transition: left 0.3s ease;
    }

    #main-content {
      margin-top: var(--header-height);
      margin-left: var(--sidebar-width);
      height: calc(100vh - var(--header-height));
      overflow-y: auto;
      padding: 1rem;
      background-color: #f5f5f5;
    }

    footer {
      text-align: center;
      font-size: 14px;
      color: #666;
      padding: 10px 0;
      border-top: 1px solid #ccc;
      margin-top: 2rem;
    }

    .nav-link.active {
      background-color: #e9ecef;
      font-weight: bold;
      color: #0a58ca;
    }

    .nav-link {
      color: #ffffff;
    }

    @media (max-width: 768px) {
      #sidebar {
        left: -240px;
      }

      #sidebar.show {
        left: 0;
      }

      #main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <nav id="header">
    <div class="d-flex align-items-center">
      <button class="btn btn-outline-light d-md-none me-2" id="toggleSidebar">☰</button>
      <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
        <img src="{{ asset('st_inv_logo.png') }}" alt="Logo" class="me-2">
        <!-- <strong>Sunface</strong> -->
      </a>
    </div>
    <div>
      @auth
        <a href="{{ route('logout') }}" class="btn btn-secondary"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
          @csrf
        </form>
      @endauth
    </div>
  </nav>

  <!-- Sidebar -->
  <div id="sidebar">
    <ul class="nav flex-column p-3">
      <li class="nav-item">
        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}" href="{{ route('customers.index') }}">
          <i class="bi bi-people me-2"></i> Customers
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link {{ request()->is('services*') ? 'active' : '' }}" href="{{ route('services.index') }}">
          <i class="bi bi-gear me-2"></i> Services
        </a>
      </li> -->
      <li class="nav-item">
        <a class="nav-link {{ request()->is('hsns*') ? 'active' : '' }}" href="{{ route('hsns.index') }}">
          <i class="bi bi-upc me-2"></i> HSN Codes
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('invoices*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">
          <i class="bi bi-receipt me-2"></i> Invoices
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('proposals*') ? 'active' : '' }}" href="{{ route('proposals.index') }}">
          <i class="bi bi-file-earmark-text me-2"></i> Proposals
        </a>
      </li>
      <!-- Dropdown -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#reportsMenu" role="button" aria-expanded="false" aria-controls="reportsMenu">
          <i class="bi bi-bar-chart me-2"></i> Reports
        </a>
        <div class="collapse {{ request()->is('reports*') ? 'show' : '' }}" id="reportsMenu">
          <ul class="nav flex-column ms-3">
            <li class="nav-item">
              <a class="nav-link {{ request()->is('reports/sales') ? 'active' : '' }}" href="{{ route('reports.sales') }}">
                <i class="bi bi-graph-up me-2"></i> Sales Report
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->is('reports/customers') ? 'active' : '' }}" href="#">
                <i class="bi bi-person-lines-fill me-2"></i> Customer Report
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('expenses*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
          <i class="bi bi-wallet2 me-2"></i> Expenses
        </a>
      </li>
    </ul>
  </div>

  <!-- Main Content -->
  <main id="main-content">
    @yield('content')

    <footer>
      &copy; {{ date('Y') }} <a href="https://sunface.in/"; target="_blank;">Sunface Technologies.</a> All rights reserved.
    </footer>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script>
    $('#toggleSidebar').on('click', function () {
      $('#sidebar').toggleClass('show');
    });
  </script>
  @yield('scripts')

</body>
</html>
