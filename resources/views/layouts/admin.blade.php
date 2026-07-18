<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Dashboard') — {{ setting('brand_word', 'Isla') }} Admin</title>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
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
  .sidebar__brand img{ width:34px; height:34px; border-radius:9px; }
  .sidebar__brand span{ font-weight:700; font-size:17px; letter-spacing:.02em; }
  .sidebar__group{ font-family:var(--mono); font-size:10px; letter-spacing:.12em; text-transform:uppercase; color:rgba(253,247,239,0.4); margin:18px 8px 8px; }
  .nav-link{ display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:8px; color:rgba(253,247,239,0.82); font-weight:500; font-size:14px; margin-bottom:2px; transition:background .15s,color .15s; }
  .nav-link:hover{ background:rgba(253,247,239,0.08); color:var(--white); }
  .nav-link.active{ background:var(--rose-deep); color:var(--white); }
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

  @media (max-width:820px){
    .layout{ grid-template-columns:1fr; }
    .sidebar{ position:static; height:auto; }
    .form-split{ grid-template-columns:1fr; }
  }
</style>
</head>
<body>
@php
  $unread = \App\Models\ContactMessage::where('is_read', false)->count();
@endphp
<div class="layout">
  <aside class="sidebar">
    <div class="sidebar__brand">
      <img src="{{ asset('logo.png') }}" alt="">
      <span>{{ setting('brand_word', 'Isla') }} Admin</span>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>

    <div class="sidebar__group">Content</div>
    <a href="{{ route('admin.audiences') }}" class="nav-link {{ request()->routeIs('admin.audiences*') ? 'active' : '' }}">Who we work with</a>
    <a href="{{ route('admin.services') }}" class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">Services</a>
    <a href="{{ route('admin.process-steps') }}" class="nav-link {{ request()->routeIs('admin.process-steps*') ? 'active' : '' }}">How it Works</a>
    <a href="{{ route('admin.benefits') }}" class="nav-link {{ request()->routeIs('admin.benefits*') ? 'active' : '' }}">Why Isla</a>
    <a href="{{ route('admin.pricing-plans') }}" class="nav-link {{ request()->routeIs('admin.pricing-plans*') ? 'active' : '' }}">Pricing</a>
    <a href="{{ route('admin.faqs') }}" class="nav-link {{ request()->routeIs('admin.faqs*') ? 'active' : '' }}">FAQ</a>

    <div class="sidebar__group">Site</div>
    <a href="{{ route('admin.nav-items') }}" class="nav-link {{ request()->routeIs('admin.nav-items*') ? 'active' : '' }}">Navigation Menu</a>
    <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">Settings</a>
    <a href="{{ route('admin.messages') }}" class="nav-link {{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
      Messages
      @if($unread) <span class="badge">{{ $unread }}</span> @endif
    </a>
  </aside>

  <div class="main">
    <div class="topbar">
      <h1>@yield('heading', 'Dashboard')</h1>
      <div class="topbar__actions">
        <a href="{{ route('isla.index') }}" target="_blank" class="btn btn-outline btn-sm">View site ↗</a>
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
</body>
</html>
