<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title', __('app.site_name'))</title>

    <style>
        :root{
            --brand-red:#D32F2F;
            --brand-red-dark:#B71C1C;
            --brand-green:#2E7D32;
            --ink:#111;
            --muted:#5f6368;
            --surface:#ffffff;
            --bg:#fafafa;
            --border:#ececec;
            --radius:14px;
            --radius-sm:10px;
            --radius-lg:18px;
            --container:1100px;
            --shadow:0 10px 30px rgba(0,0,0,.06);
            --focus:0 0 0 3px rgba(211,47,47,.2);
        }
        *{box-sizing:border-box}
        html,body{margin:0;padding:0;background:var(--bg);color:var(--ink);font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial;line-height:1.6}
        a{color:var(--brand-red);text-decoration:none}
        a:hover{text-decoration:underline}
        img{max-width:100%;display:block}
        .container{max-width:var(--container);margin:0 auto;padding:0 16px}

        /* Header */
        .site-header{
            background:var(--brand-red);
            color:#fff;
            position:relative;
        }
        .topbar{
            display:flex;align-items:center;justify-content:space-between;
            gap:16px;padding:16px 0;
        }
        .brand{
            display:flex;align-items:center;gap:10px;font-weight:900;letter-spacing:.5px
        }
        .brand .logo{
            display:inline-block;background:#fff;color:var(--brand-red);
            font-weight:900;padding:8px 10px;border-radius:8px;line-height:1
        }
        .brand .name{font-size:22px}
        .nav{
            display:flex;align-items:center;gap:20px;flex-wrap:wrap
        }
        .nav a{
            color:#fff;font-weight:700;opacity:.9
        }
        .nav a.active,.nav a:hover{opacity:1;text-decoration:none;border-bottom:2px solid #fff}
        .lang-switch{
            display:flex;align-items:center;gap:10px;color:#fff
        }
        .hero-wrap{
            position:relative;overflow:hidden
        }
        .hero{
            padding:48px 0 80px;
            display:grid;grid-template-columns:1.1fr .9fr;gap:30px;align-items:center
        }
        .hero-title{
            font-size:52px;font-weight:900;line-height:1.05;margin:0 0 12px;color:#fff
        }
        .hero-sub{color:#ffecec;font-size:18px;margin:0 0 22px}
        .cta-row{display:flex;gap:12px;flex-wrap:wrap}
        .btn{
            display:inline-flex;align-items:center;justify-content:center;gap:8px;
            border:0;border-radius:999px;padding:12px 20px;font-weight:800;cursor:pointer
        }
        .btn-primary{background:#fff;color:var(--brand-red)}
        .btn-ghost{background:transparent;color:#fff;border:2px solid #fff}
        .stats-card{
            position:relative;left:50%;transform:translateX(-50%);
            margin-top:-120px;margin-bottom:48px;background:rgba(255,255,255,0.98);border:1px solid var(--border);border-radius:18px;
            display:grid;grid-template-columns:repeat(3,1fr);gap:0;min-width:min(96%,1000px);
            box-shadow:0 25px 50px rgba(0,0,0,0.25), 0 12px 24px rgba(0,0,0,0.15), 0 6px 12px rgba(0,0,0,0.1);
            overflow:hidden;
            backdrop-filter:blur(20px);
            border:1px solid rgba(255,255,255,0.5);
            transition:all 0.3s ease;
            z-index:1000;
        }
        .stats-card:hover{
            transform:translateX(-50%) translateY(-5px);
            box-shadow:0 30px 60px rgba(0,0,0,0.3), 0 15px 30px rgba(0,0,0,0.2), 0 8px 16px rgba(0,0,0,0.15);
        }
        .stat{
            padding:24px 20px;
            text-align:center;
            position:relative;
            transition:all 0.3s ease;
            z-index:1001;
            background:rgba(255,255,255,0.3);
        }
        .stat:hover{
            background:rgba(255,255,255,0.5);
            transform:scale(1.02);
        }
        .stat + .stat{border-inline-start:1px solid var(--border)}
        .stat .v{
            color:var(--brand-red);
            font-weight:900;
            font-size:32px;
            line-height:1.2;
            margin-bottom:8px;
            display:block;
            text-shadow:0 2px 4px rgba(0,0,0,0.15);
            letter-spacing:-0.5px;
            position:relative;
            z-index:1002;
        }
        .stat .l{
            color:#222;
            font-weight:700;
            font-size:11px;
            letter-spacing:1px;
            text-transform:uppercase;
            opacity:0.9;
            line-height:1.4;
            margin-bottom:6px;
            position:relative;
            z-index:1002;
            text-shadow:0 1px 2px rgba(0,0,0,0.1);
        }
        .stat-description{
            color:#555;
            font-size:9px;
            font-weight:500;
            line-height:1.3;
            opacity:0.8;
            margin-top:4px;
            position:relative;
            z-index:1002;
            text-shadow:0 1px 1px rgba(0,0,0,0.05);
        }
        .visual{
            position:relative;align-self:stretch;min-height:320px
        }
        .visual .flag{
            position:absolute;inset:auto 0 -40px auto;width:100%;max-width:420px;filter:drop-shadow(0 12px 30px rgba(0,0,0,.25))
        }

        /* Sections common */
        h1,h2,h3{line-height:1.2;color:#111}
        h2.section-title{font-size:34px;margin:0 0 12px;font-weight:900}
        p.lead{color:var(--muted);font-size:18px;margin:0 0 18px}

        /* Cards */
        .card{
            background:var(--surface);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:.2s;box-shadow:0 6px 16px rgba(0,0,0,.05)
        }
        .card:hover{transform:translateY(-4px);box-shadow:0 14px 28px rgba(0,0,0,.08)}
        .card .p{padding:16px}
        .clickable-card{cursor:pointer;position:relative}
        .clickable-card img{height:200px;object-fit:cover;width:100%}

        /* Buttons secondary/green */
        .btn-green{background:var(--brand-green);color:#fff}
        .btn-dark{background:#111;color:#fff}

        /* Footer */
        .site-footer{margin-top:80px;background:#111;color:#fff}
        .site-footer .grid{display:grid;grid-template-columns:2fr 1fr 1fr;gap:20px;padding:40px 0}
        .site-footer h4{margin:0 0 10px}
        .site-footer a{color:#ddd}
        .footer-bottom{border-top:1px solid rgba(255,255,255,.1);padding:14px 0;color:#bbb;font-size:14px}

        /* Helpers */
        .grid{display:grid;gap:16px}
        .grid-2{grid-template-columns:1fr 1fr}
        .grid-3{grid-template-columns:repeat(3,1fr)}
        .muted{color:var(--muted)}
        .badge{display:inline-block;background:#f1f3f4;border:1px solid var(--border);border-radius:999px;padding:6px 10px;font-weight:700}

        /* Responsive */
        @media (max-width:1024px){
            .hero{grid-template-columns:1fr;gap:18px;padding-bottom:48px}
            .visual{min-height:220px}
            .visual .flag{position:relative;inset:auto;max-width:340px;margin:0 auto}
            .stats-card{margin-top:-100px;margin-bottom:40px}
            .site-footer .grid{grid-template-columns:1fr 1fr}
        }
        @media (max-width:680px){
            .hero-title{font-size:40px}
            .stats-card{
                grid-template-columns:1fr;
                min-width:92%;
                margin-top:-80px;margin-bottom:30px;
                box-shadow:0 20px 40px rgba(0,0,0,0.2), 0 10px 20px rgba(0,0,0,0.15);
                z-index:1000;
            }
            .stat + .stat{border-inline-start:0;border-top:1px solid var(--border)}
            .stat .v{font-size:28px}
            .stat .l{font-size:10px}
            .stat-description{font-size:8px}
            .nav{gap:12px}
            .brand .name{font-size:18px}
            .site-footer .grid{grid-template-columns:1fr}
        }
        @media (max-width:480px){
            .stats-card{
                margin-top:-25px;margin-bottom:25px;
                min-width:95%;
                border-radius:14px;
                z-index:1000;
            }
            .stat{padding:20px 16px}
            .stat .v{font-size:24px}
            .stat .l{font-size:9px;letter-spacing:0.5px}
            .stat-description{font-size:7px;margin-top:2px}
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="container topbar">
            <div class="brand">
                <span class="logo">W</span>
                <span class="name">{{ __('app.site_name') }}</span>
            </div>
            <nav class="nav">
@php
$currentLocale = app()->getLocale();
$homeUrl = url($currentLocale); // ينتج /en أو /ar
@endphp
<a href="{{ $homeUrl }}" class="{{ request()->is($currentLocale) || request()->is($currentLocale.'/*') ? 'active' : '' }}">{{ __('app.nav.home') }}</a>                <a href="{{ route('cases.index') }}" class="{{ request()->is('*cases*') ? 'active' : '' }}">{{ __('app.nav.cases') }}</a>
                <a href="{{ route('posts.index') }}" class="{{ request()->is('*posts*') ? 'active' : '' }}">{{ __('app.nav.blog') }}</a>
                <a href="{{ route('about') }}" class="{{ request()->is('*about*') ? 'active' : '' }}">{{ __('app.nav.about') }}</a>
                <a href="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('contact') }}" class="{{ request()->is('*contact*') ? 'active' : '' }}">{{ __('app.nav.contact') }}</a>
            </nav>
            <div class="lang-switch">
                <span>{{ \App\Helpers\LanguageHelper::getLocaleName() }}</span>
                @php
                    $currentLocale = app()->getLocale();
                    $oppositeLocale = $currentLocale === 'ar' ? 'en' : 'ar';
                    $currentPath = request()->path();
                    $pathWithoutLocale = preg_replace('/^(en|ar)\/?/', '', $currentPath);
                    $oppositeUrl = url($oppositeLocale . '/' . $pathWithoutLocale);
                @endphp
                <a class="btn btn-ghost" href="{{ $oppositeUrl }}">{{ $currentLocale === 'en' ? __('app.nav.arabic') : __('app.nav.english') }}</a>
            </div>
        </div>

        <div class="hero-wrap">
            @yield('hero')
        </div>
    </header>

    <main class="container" style="margin-top:80px">
        @if(session('success'))
            <div class="badge">{{ __('app.messages.success') }}: {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="badge" style="background:#ffe3e3;border-color:#ffc8c8;color:#a00">{{ __('app.messages.error') }}: {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container grid">
            <div>
                <h4>{{ __('app.site_name') }}</h4>
                <p>{{ __('app.footer.description') }}</p>
                <p class="muted" style="margin-top:10px">{{ __('app.footer.belief') }}</p>
            </div>
            <div>
                <h4>{{ __('app.footer.quick_links') }}</h4>
                <div style="display:flex;flex-direction:column;gap:6px">
                    @php $loc = app()->getLocale(); @endphp<a href="{{ url($loc) }}">{{ __('app.nav.home') }}</a>
                    <a href="{{ route('cases.index') }}">{{ __('app.buttons.all_appeals') }}</a>
                    <a href="{{ route('posts.index') }}">{{ __('app.buttons.all_posts') }}</a>
                    <a href="{{ route('about') }}">{{ __('app.nav.about') }}</a>
                    <a href="{{ \App\Helpers\LanguageHelper::getLocalizedRoute('contact') }}">{{ __('app.nav.contact') }}</a>
                </div>
            </div>
            <div>
                <h4>{{ __('app.footer.contact') }}</h4>
                <div style="display:flex;flex-direction:column;gap:6px">
                    <span>{{ __('app.footer.email') }}: <a href="mailto:support@wallsmust.org">support@wallsmust.org</a></span>
                    <span>{{ __('app.footer.whatsapp') }}: +970 599 000 000</span>
                    <a class="btn btn-green" href="{{ route('cases.index') }}" style="margin-top:10px">{{ __('app.footer.support_now') }}</a>
                </div>
            </div>
        </div>
        <div class="container footer-bottom">
            <small>{{ __('app.footer.copyright', ['year' => date('Y')]) }} · {{ __('app.footer.no_user_registration') }}</small>
        </div>
    </footer>
</body>
</html>