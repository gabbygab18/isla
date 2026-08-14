<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard') — {{ setting('brand_word', 'Isla') }} Admin</title>
<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;450;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root{
    --cream:#fdf7ef; --white:#fff; --rose:#db9496; --sage:#8f9d77;
    --ink:#2b2723; --ink-soft:#6b6259; --rose-deep:#c17579; --sage-deep:#6f7d5c;
    --rose-soft:#f2dcdd; --sage-soft:#e6e9db; --hairline:rgba(43,39,35,0.14);
    --sidebar:#2b2723; --radius:10px;
    --font:'Inter',system-ui,sans-serif; --mono:'JetBrains Mono',monospace;
  }
  *,*::before,*::after{ box-sizing:border-box; }
  body{ margin:0; font-family:var(--font); background:var(--cream); color:var(--ink); font-size:15px; }
  a{ color:inherit; text-decoration:none; }

  .layout{ display:grid; grid-template-columns:250px 1fr; min-height:100vh; }

  /* Sidebar */
  .sidebar{ background:var(--sidebar); color:var(--cream); padding:22px 16px; position:sticky; top:0; height:100vh; overflow-y:auto; }
  .sidebar__brand{ display:flex; align-items:center; gap:10px; padding:0 8px 18px; margin-bottom:12px; border-bottom:1px solid rgba(253,247,239,0.12); }
  .sidebar__brand img{ height:38px; width:auto; }
  .sidebar__group{ font-family:var(--mono); font-size:10px; letter-spacing:.12em; text-transform:uppercase; color:rgba(253,247,239,0.4); margin:18px 8px 8px; }
  .nav-link{ display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:rgba(253,247,239,0.82); font-weight:500; font-size:14px; margin-bottom:2px; transition:background .15s,color .15s; }
  .nav-link:hover{ background:rgba(253,247,239,0.08); color:var(--white); }
  .nav-link.active{ background:var(--rose-deep); color:var(--white); }
  .nav-link svg{ width:16px; height:16px; flex-shrink:0; opacity:.85; }
  .nav-link .badge{ margin-left:auto; background:var(--rose); color:var(--ink); border-radius:999px; font-size:11px; font-weight:700; padding:1px 8px; }

  /* Main */
  .main{ display:flex; flex-direction:column; min-width:0; }
  .topbar{ background:var(--white); border-bottom:1px solid var(--hairline); padding:14px 28px; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:20; }
  .topbar h1{ font-size:19px; font-weight:700; margin:0; }
  .topbar__actions{ display:flex; gap:10px; align-items:center; }
  .content{ padding:28px; max-width:1100px; width:100%; }

  /* Buttons */
  .btn{ display:inline-flex; align-items:center; gap:7px; font-family:var(--font); font-weight:600; font-size:14px; border-radius:8px; padding:9px 16px; cursor:pointer; border:1px solid transparent; transition:transform .12s,background .15s,opacity .15s; }
  .btn:hover{ transform:translateY(-1px); }
  .btn-primary{ background:var(--ink); color:var(--cream); }
  .btn-primary:hover{ background:var(--rose-deep); }
  .btn-outline{ background:var(--white); color:var(--ink); border-color:var(--hairline); }
  .btn-outline:hover{ background:var(--cream); }
  .btn-rose{ background:var(--rose-deep); color:var(--white); }
  .btn-danger{ background:transparent; color:#b23b3b; border-color:rgba(178,59,59,.3); }
  .btn-danger:hover{ background:#fbeaea; }
  .btn-sm{ padding:6px 12px; font-size:13px; }

  /* Cards / tables */
  .card-box{ background:var(--white); border:1px solid var(--hairline); border-radius:var(--radius); padding:22px; margin-bottom:22px; }
  .table{ width:100%; border-collapse:collapse; background:var(--white); border:1px solid var(--hairline); border-radius:var(--radius); overflow:hidden; }
  .table th{ text-align:left; font-family:var(--mono); font-size:10.5px; letter-spacing:.08em; text-transform:uppercase; color:var(--ink-soft); padding:12px 16px; background:var(--cream); border-bottom:1px solid var(--hairline); }
  .table td{ padding:13px 16px; border-bottom:1px solid var(--hairline); vertical-align:middle; }
  .table tr:last-child td{ border-bottom:none; }
  .table tr:hover td{ background:#fffdf9; }
  .table__actions{ display:flex; gap:8px; justify-content:flex-end; }
  .muted{ color:var(--ink-soft); font-size:13px; }

  .pill{ display:inline-block; font-size:11px; font-weight:700; padding:3px 10px; border-radius:999px; }
  .pill-on{ background:var(--sage-soft); color:var(--sage-deep); }
  .pill-off{ background:#eee; color:#888; }
  .pill-rose{ background:var(--rose-soft); color:var(--rose-deep); }

  /* Stat grid */
  .stat-grid{ display:grid; grid-template-columns:repeat(auto-fill,minmax(160px,1fr)); gap:16px; margin-bottom:26px; }
  .stat{ background:var(--white); border:1px solid var(--hairline); border-radius:var(--radius); padding:18px; }
  .stat__num{ font-size:30px; font-weight:800; line-height:1; }
  .stat__label{ font-family:var(--mono); font-size:10.5px; letter-spacing:.08em; text-transform:uppercase; color:var(--ink-soft); margin-top:8px; }
  .stat a{ color:var(--rose-deep); font-weight:600; font-size:12.5px; }

  /* Forms */
  .form-grid{ display:grid; gap:18px; max-width:720px; }
  .form-row{ display:grid; gap:6px; }
  .form-row label{ font-family:var(--mono); font-size:11px; letter-spacing:.05em; text-transform:uppercase; color:var(--ink-soft); font-weight:500; }
  .form-row input, .form-row textarea, .form-row select{ width:100%; padding:10px 12px; border:1px solid var(--hairline); border-radius:8px; font-family:var(--font); font-size:14px; background:var(--white); color:var(--ink); }
  .form-row textarea{ resize:vertical; min-height:90px; }
  .form-row .hint{ font-size:12px; color:var(--ink-soft); }
  .form-split{ display:grid; grid-template-columns:1fr 1fr; gap:16px; }
  .form-check{ display:flex; align-items:center; gap:9px; }
  .form-check input{ width:auto; }
  .form-check label{ text-transform:none; letter-spacing:0; font-family:var(--font); font-size:14px; color:var(--ink); }
  .form-actions{ display:flex; gap:10px; margin-top:6px; }
  .field-error{ color:#b23b3b; font-size:12.5px; }

  /* Flash */
  .flash{ padding:12px 16px; border-radius:8px; margin-bottom:20px; font-weight:600; font-size:14px; }
  .flash-success{ background:var(--sage-soft); color:var(--sage-deep); }
  .flash-error{ background:#fbeaea; color:#b23b3b; }

  .page-head{ display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
  .page-head h2{ margin:0; font-size:22px; font-weight:700; }

  /* Mobile nav */
  .menu-toggle{ display:none; align-items:center; justify-content:center; width:36px; height:36px; border:1px solid var(--hairline); border-radius:8px; background:var(--white); cursor:pointer; }
  .menu-toggle svg{ width:18px; height:18px; }
  .sidebar-overlay{ display:none; }

  @media (max-width:820px){
    .layout{ grid-template-columns:1fr; }
    .sidebar{ position:fixed; top:0; left:0; height:100vh; width:250px; z-index:50; transform:translateX(-100%); transition:transform .25s ease; box-shadow:0 0 24px rgba(0,0,0,.25); }
    body.sidebar-open .sidebar{ transform:translateX(0); }
    body.sidebar-open .sidebar-overlay{ display:block; position:fixed; inset:0; background:rgba(0,0,0,.4); z-index:40; }
    .menu-toggle{ display:flex; }
    .form-split{ grid-template-columns:1fr; }
    .topbar{ padding:12px 16px; flex-wrap:wrap; gap:10px; }
    .topbar h1{ font-size:16px; }
    .view-site-link{ display:none; }
    .content{ padding:16px; }
    .stat-grid{ grid-template-columns:repeat(auto-fill,minmax(130px,1fr)); gap:10px; }
  }
</style>
</head>
<body>
@php
  $unread = \App\Models\ContactMessage::where('is_read', false)->count();
@endphp
<div class="sidebar-overlay" onclick="document.body.classList.remove('sidebar-open')"></div>
<div class="layout">
  <aside class="sidebar">
    <div class="sidebar__brand">
      <img src="{{ asset('logo.png') }}" alt="{{ setting('brand_word', 'Isla') }} Admin">
    </div>

    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>Dashboard</a>

    <div class="sidebar__group">Content</div>
    <a href="{{ route('admin.audiences') }}" class="nav-link {{ request()->routeIs('admin.audiences*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>Who we work with</a>
    <a href="{{ route('admin.services') }}" class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>Services</a>
    <a href="{{ route('admin.process-steps') }}" class="nav-link {{ request()->routeIs('admin.process-steps*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="10" x2="21" y1="6" y2="6"/><line x1="10" x2="21" y1="12" y2="12"/><line x1="10" x2="21" y1="18" y2="18"/><path d="M4 6h1v4"/><path d="M4 10h2"/><path d="M6 18H4c0-1 2-2 2-3s-1-1.5-2-1"/></svg>How it Works</a>
    <a href="{{ route('admin.benefits') }}" class="nav-link {{ request()->routeIs('admin.benefits*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"/></svg>Why Isla</a>
    <a href="{{ route('admin.pricing-plans') }}" class="nav-link {{ request()->routeIs('admin.pricing-plans*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12.586 2.586A2 2 0 0 0 11.172 2H4a2 2 0 0 0-2 2v7.172a2 2 0 0 0 .586 1.414l8.704 8.704a2.426 2.426 0 0 0 3.42 0l6.58-6.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="7.5" cy="7.5" r=".5" fill="currentColor"/></svg>Pricing</a>
    <a href="{{ route('admin.faqs') }}" class="nav-link {{ request()->routeIs('admin.faqs*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>FAQ</a>
    <a href="{{ route('admin.testimonials') }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"/><path d="M5 3a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2 1 1 0 0 1 1 1v1a2 2 0 0 1-2 2 1 1 0 0 0-1 1v2a1 1 0 0 0 1 1 6 6 0 0 0 6-6V5a2 2 0 0 0-2-2z"/></svg>Testimonials</a>
    <a href="{{ route('admin.blogs') }}" class="nav-link {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/><line x1="9" x2="15" y1="7" y2="7"/><line x1="9" x2="13" y1="11" y2="11"/></svg>Blog</a>

    <div class="sidebar__group">Site</div>
    <a href="{{ route('admin.nav-items') }}" class="nav-link {{ request()->routeIs('admin.nav-items*') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/></svg>Navigation Menu</a>
    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="21" x2="14" y1="4" y2="4"/><line x1="10" x2="3" y1="4" y2="4"/><line x1="21" x2="12" y1="12" y2="12"/><line x1="8" x2="3" y1="12" y2="12"/><line x1="21" x2="16" y1="20" y2="20"/><line x1="12" x2="3" y1="20" y2="20"/><line x1="14" x2="14" y1="2" y2="6"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="16" x2="16" y1="18" y2="22"/></svg>Settings</a>
    <a href="{{ route('admin.messages') }}" class="nav-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
      Messages
      @if($unread) <span class="badge">{{ $unread }}</span> @endif
    </a>
    <a href="{{ route('admin.applications') }}" class="nav-link {{ request()->routeIs('admin.applications*') ? 'active' : '' }}">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
      Careers
      @if($newApplications) <span class="badge">{{ $newApplications }}</span> @endif
    </a>
  </aside>

  <div class="main">
    <div class="topbar">
      <div style="display:flex;align-items:center;gap:12px;">
        <button type="button" class="menu-toggle" aria-label="Toggle menu" onclick="document.body.classList.toggle('sidebar-open')">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </button>
        <h1>@yield('heading', 'Dashboard')</h1>
      </div>
      <div class="topbar__actions">
        <a href="{{ route('isla.index') }}" target="_blank" class="btn btn-outline btn-sm view-site-link">View site ↗</a>
        <form method="POST" action="{{ route('admin.logout') }}">
          @csrf
          <button type="submit" class="btn btn-outline btn-sm">Log out</button>
        </form>
      </div>
    </div>

    <div class="content">
      @if (session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
      @endif
      @if (session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
      @endif
      @if ($errors->any())
        <div class="flash flash-error">Please fix the errors below.</div>
      @endif

      @yield('content')
    </div>
  </div>
</div>
<script>
  document.querySelectorAll('.sidebar .nav-link').forEach(function (link) {
    link.addEventListener('click', function () {
      document.body.classList.remove('sidebar-open');
    });
  });
</script>
</body>
</html>
