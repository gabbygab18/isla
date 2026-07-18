<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign in — {{ setting('brand_word', 'Isla') }} Admin</title>
<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<style>
  :root{ --cream:#fdf7ef; --white:#fff; --rose-deep:#c17579; --ink:#2b2723; --ink-soft:#6b6259; --hairline:rgba(43,39,35,0.14); }
  *{ box-sizing:border-box; }
  body{ margin:0; min-height:100vh; display:flex; align-items:center; justify-content:center; background:var(--cream); font-family:'Inter',system-ui,sans-serif; color:var(--ink); padding:20px; }
  .card{ background:var(--white); border:1px solid var(--hairline); border-radius:16px; padding:38px 34px; width:100%; max-width:390px; box-shadow:0 24px 60px -30px rgba(43,39,35,.35); }
  .brand{ display:flex; align-items:center; gap:11px; justify-content:center; margin-bottom:22px; }
  .brand img{ width:42px; height:42px; border-radius:11px; }
  .brand span{ font-weight:700; font-size:20px; letter-spacing:.02em; }
  h1{ font-size:21px; margin:0 0 4px; text-align:center; }
  .sub{ text-align:center; color:var(--ink-soft); font-size:14px; margin:0 0 24px; }
  label{ display:block; font-family:'JetBrains Mono',monospace; font-size:11px; letter-spacing:.05em; text-transform:uppercase; color:var(--ink-soft); margin-bottom:6px; }
  input[type=email],input[type=password]{ width:100%; padding:11px 13px; border:1px solid var(--hairline); border-radius:9px; font-size:14px; font-family:inherit; margin-bottom:16px; }
  .check{ display:flex; align-items:center; gap:8px; margin-bottom:20px; font-size:14px; color:var(--ink-soft); }
  button{ width:100%; padding:12px; border:none; border-radius:9px; background:var(--ink); color:var(--cream); font-weight:600; font-size:15px; cursor:pointer; transition:background .15s; }
  button:hover{ background:var(--rose-deep); }
  .alert{ background:#fbeaea; color:#b23b3b; border-radius:9px; padding:11px 14px; font-size:13.5px; margin-bottom:18px; font-weight:600; }
  .hint{ text-align:center; font-size:12.5px; color:var(--ink-soft); margin-top:18px; }
</style>
</head>
<body>
  <div class="card">
    <div class="brand">
      <img src="{{ asset('logo.png') }}" alt="">
      <span>{{ setting('brand_word', 'Isla') }}</span>
    </div>
    <h1>Admin sign in</h1>
    <p class="sub">Manage your site content</p>

    @if($errors->any())
      <div class="alert">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>

      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>

      <div class="check">
        <input type="checkbox" name="remember" id="remember">
        <label for="remember" style="text-transform:none; letter-spacing:0; font-family:inherit; margin:0; color:var(--ink-soft);">Remember me</label>
      </div>

      <button type="submit">Sign in</button>
    </form>

    <p class="hint">Default: admin@isla.com.au / password</p>
  </div>
</body>
</html>
