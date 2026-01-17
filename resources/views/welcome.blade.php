<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
  <meta charset="UTF-8">
  <title>About Asset Management System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  {{-- Bootstrap Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- Animate On Scroll --}}
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      transition: background-color 0.3s, color 0.3s;
      padding-top: 60px;
      height: 100%;
    }

    .section-title {
      font-size: 2rem;
      font-weight: 700;
    }

    .feature-icon {
      font-size: 1.8rem;
      color: #6366f1;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .card:hover {
      transform: translateY(-6px);
    }

    [data-bs-theme="dark"] {
      background-color: #121212;
      color: #f1f1f1;
    }

    [data-bs-theme="dark"] .card {
      background-color: #1f1f1f;
      color: #fff;
    }

    .theme-toggle {
      cursor: pointer;
    }

    .switch-icon {
      font-size: 1.3rem;
    }
  </style>
</head>
<body>

<div class="container">

  {{-- Header Controls --}}
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('filament.admin.pages.dashboard') }}" class="btn btn-outline-secondary">
      <i class="bi bi-house-door-fill me-1"></i> Dashboard
    </a>

    <button id="themeToggle" class="btn btn-outline-secondary theme-toggle">
      <i class="bi bi-moon switch-icon"></i>
    </button>
  </div>

  {{-- Title --}}
  <div class="text-center mb-5" data-aos="fade-up">
    <h1 class="section-title">📦 Asset Management System</h1>
    <p class="lead">A modern platform to track, maintain, and secure your assets with full control and visibility.</p>
  </div>

  {{-- Features --}}
  <div class="row g-4">
    @php
    $features = [
      ['icon' => 'bi-bar-chart-line-fill', 'title' => 'Real-Time Monitoring', 'desc' => 'Live tracking for asset conditions, overdue maintenance, and lifecycle status.'],
      ['icon' => 'bi-pie-chart-fill', 'title' => 'Visual Reports', 'desc' => 'Dashboards with dynamic charts for trends, usage, and breakdowns.'],
      ['icon' => 'bi-person-lock', 'title' => 'Role-Based Access', 'desc' => 'Access control based on user roles with admin-only permissions for critical actions.'],
      ['icon' => 'bi-bell-fill', 'title' => 'Notifications', 'desc' => 'Custom alerts for expiring warranties, maintenance, and asset status changes.'],
      ['icon' => 'bi-clipboard-check', 'title' => 'Approval System', 'desc' => 'Deletion and updates require admin approval to prevent unauthorized changes.'],
      ['icon' => 'bi-clock-history', 'title' => 'Audit Logs', 'desc' => 'Track every change, who did it, and when — full accountability.'],
      ['icon' => 'bi-folder-fill', 'title' => 'Document Storage', 'desc' => 'Attach invoices, manuals, and photos to every asset record.'],
      ['icon' => 'bi-recycle', 'title' => 'Maintenance Scheduling', 'desc' => 'Plan recurring maintenance and get automatic reminders.'],
      ['icon' => 'bi-diagram-3-fill', 'title' => 'Department Segmentation', 'desc' => 'Group assets by department and manage independently.'],
      ['icon' => 'bi-cloud-arrow-down-fill', 'title' => 'Backup & Restore', 'desc' => 'Secure your data with backup and easy recovery options.'],
      ['icon' => 'bi-plug-fill', 'title' => 'API Integration', 'desc' => 'Connect with HR, inventory, and procurement systems.'],
      ['icon' => 'bi-speedometer2', 'title' => 'Performance Insights', 'desc' => 'Understand what assets perform best and where issues arise.'],
    ];
    @endphp

    @foreach($features as $index => $feature)
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ 100 + ($index * 50) }}">
        <div class="card p-4 h-100">
          <div class="mb-3">
            <i class="bi {{ $feature['icon'] }} feature-icon"></i>
          </div>
          <h5>{{ $feature['title'] }}</h5>
          <p>{{ $feature['desc'] }}</p>
        </div>
      </div>
    @endforeach
  </div>

</div>
<div class="py-5"></div>
{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({ once: true, duration: 800 });

  const toggle = document.getElementById('themeToggle');
  const icon = toggle.querySelector('i');
  const html = document.documentElement;

  toggle.addEventListener('click', () => {
    const isDark = html.getAttribute('data-bs-theme') === 'dark';
    html.setAttribute('data-bs-theme', isDark ? 'light' : 'dark');
    icon.className = isDark ? 'bi bi-moon switch-icon' : 'bi bi-sun switch-icon';
  });

  // Detect preferred system mode
  if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
    html.setAttribute('data-bs-theme', 'dark');
    icon.className = 'bi bi-sun switch-icon';
  }
</script>

</body>
</html>
