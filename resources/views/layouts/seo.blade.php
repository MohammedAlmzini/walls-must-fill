<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    
    <!-- Basic SEO Meta Tags -->
    <title>{{ $seoMeta['title'] ?? __('app.site_name') }}</title>
    <meta name="description" content="{{ $seoMeta['description'] ?? '' }}">
    <meta name="keywords" content="{{ $seoMeta['keywords'] ?? '' }}">
    <meta name="author" content="{{ $seoMeta['author'] ?? 'Walls Must' }}">
    <meta name="robots" content="index, follow">
    <meta name="language" content="{{ $seoMeta['locale'] ?? app()->getLocale() }}">
    <meta name="revisit-after" content="7 days">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ $seoMeta['url'] ?? request()->url() }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="{{ $seoMeta['type'] ?? 'website' }}">
    <meta property="og:url" content="{{ $seoMeta['url'] ?? request()->url() }}">
    <meta property="og:title" content="{{ $seoMeta['og_title'] ?? $seoMeta['title'] ?? __('app.site_name') }}">
    <meta property="og:description" content="{{ $seoMeta['og_description'] ?? $seoMeta['description'] ?? '' }}">
    <meta property="og:image" content="{{ $seoMeta['og_image'] ?? $seoMeta['image'] ?? asset('images/og-default.jpg') }}">
    <meta property="og:site_name" content="{{ $seoMeta['site_name'] ?? 'Walls Must' }}">
    <meta property="og:locale" content="{{ $seoMeta['locale'] ?? app()->getLocale() }}">
    @if(isset($seoMeta['published_time']))
    <meta property="article:published_time" content="{{ $seoMeta['published_time'] }}">
    @endif
    @if(isset($seoMeta['author']))
    <meta property="article:author" content="{{ $seoMeta['author'] }}">
    @endif
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ $seoMeta['url'] ?? request()->url() }}">
    <meta property="twitter:title" content="{{ $seoMeta['twitter_title'] ?? $seoMeta['title'] ?? __('app.site_name') }}">
    <meta property="twitter:description" content="{{ $seoMeta['twitter_description'] ?? $seoMeta['description'] ?? '' }}">
    <meta property="twitter:image" content="{{ $seoMeta['twitter_image'] ?? $seoMeta['image'] ?? asset('images/og-default.jpg') }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    
    <!-- Structured Data -->
    @if(isset($seoMeta['structured_data']))
    <script type="application/ld+json">
        {!! json_encode($seoMeta['structured_data'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    @elseif(isset($structuredData))
    <script type="application/ld+json">
        {!! json_encode($structuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
    @endif
    
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
        
        /* Language Switcher */
        .lang-switch{
            display:flex;align-items:center;gap:8px
        }
        .current-lang{
            font-size:14px;opacity:.8;font-weight:600
        }
        .switch-lang{
            background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.2);
            padding:6px 12px;border-radius:6px;font-size:13px;font-weight:600;
            transition:all .2s ease
        }
        .switch-lang:hover{
            background:rgba(255,255,255,.2);border-color:rgba(255,255,255,.3);
            text-decoration:none;transform:translateY(-1px)
        }
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
        }
        .stat-item{
            padding:32px 24px;text-align:center;border-right:1px solid var(--border)
        }
        .stat-item:last-child{border-right:0}
        .stat-value{
            font-size:36px;font-weight:900;color:var(--brand-red);margin:0 0 8px
        }
        .stat-label{
            font-size:14px;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.5px
        }
        .features{
            padding:80px 0;background:var(--surface)
        }
        .features-grid{
            display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:32px
        }
        .feature-card{
            background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-lg);
            padding:32px;text-align:center;transition:all .3s ease
        }
        .feature-card:hover{
            transform:translateY(-4px);box-shadow:var(--shadow)
        }
        .feature-icon{
            width:64px;height:64px;background:var(--brand-red);border-radius:50%;
            display:flex;align-items:center;justify-content:center;margin:0 auto 20px;
            font-size:24px;color:#fff
        }
        .feature-title{
            font-size:20px;font-weight:700;margin:0 0 12px;color:var(--ink)
        }
        .feature-desc{
            color:var(--muted);line-height:1.6
        }
        .cta-section{
            padding:80px 0;background:var(--brand-red);color:#fff;text-align:center
        }
        .cta-title{
            font-size:36px;font-weight:900;margin:0 0 16px
        }
        .cta-desc{
            font-size:18px;opacity:.9;margin:0 0 32px;max-width:600px;margin-left:auto;margin-right:auto
        }
        .cta-buttons{
            display:flex;gap:16px;justify-content:center;flex-wrap:wrap
        }
        .btn-white{
            background:#fff;color:var(--brand-red);border:2px solid #fff
        }
        .btn-outline{
            background:transparent;color:#fff;border:2px solid #fff
        }
        .btn-outline:hover{
            background:#fff;color:var(--brand-red)
        }
        .footer{
            background:var(--ink);color:#fff;padding:48px 0 24px
        }
        .footer-content{
            display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:32px
        }
        .footer-section h3{
            font-size:18px;font-weight:700;margin:0 0 16px
        }
        .footer-section p{
            opacity:.8;line-height:1.6
        }
        .footer-bottom{
            border-top:1px solid rgba(255,255,255,.1);margin-top:32px;padding-top:24px;
            text-align:center;opacity:.7
        }
        @media (max-width:768px){
            .hero{grid-template-columns:1fr;text-align:center;padding:32px 0 60px}
            .hero-title{font-size:36px}
            .stats-card{grid-template-columns:1fr;margin-top:-80px}
            .stat-item{border-right:0;border-bottom:1px solid var(--border)}
            .stat-item:last-child{border-bottom:0}
            .features-grid{grid-template-columns:1fr}
            .cta-buttons{flex-direction:column;align-items:center}
            .btn{width:100%;max-width:300px}
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="site-header">
        <div class="container">
            <div class="topbar">
                <div class="brand">
                    <span class="logo">WM</span>
                    <span class="name">{{ __('app.site_name') }}</span>
                </div>
                <nav class="nav">
                    <a href="{{ route('en.home') }}" class="{{ request()->routeIs('en.home') ? 'active' : '' }}">{{ __('app.nav.home') }}</a>
                    <a href="{{ route('en.about') }}" class="{{ request()->routeIs('en.about') ? 'active' : '' }}">{{ __('app.nav.about') }}</a>
                    <a href="{{ route('en.contact') }}" class="{{ request()->routeIs('en.contact') ? 'active' : '' }}">{{ __('app.nav.contact') }}</a>
                    <a href="{{ route('en.cases.index') }}" class="{{ request()->routeIs('en.cases.*') ? 'active' : '' }}">{{ __('app.nav.cases') }}</a>
                    <a href="{{ route('en.posts.index') }}" class="{{ request()->routeIs('en.posts.*') ? 'active' : '' }}">{{ __('app.nav.blog') }}</a>
                </nav>
                <div class="lang-switch">
                    <span class="current-lang">{{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}</span>
                    <a href="{{ app()->getLocale() === 'ar' ? route('en.home') : route('ar.home') }}" class="switch-lang">
                        {{ app()->getLocale() === 'ar' ? 'English' : 'العربية' }}
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main>
    @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>{{ __('app.site_name') }}</h3>
                    <p>{{ __('app.footer.description') }}</p>
                </div>
                <div class="footer-section">
                    <h3>{{ __('app.footer.quick_links') }}</h3>
                    <p><a href="{{ route('en.about') }}">{{ __('app.nav.about') }}</a></p>
                    <p><a href="{{ route('en.contact') }}">{{ __('app.nav.contact') }}</a></p>
                    <p><a href="{{ route('en.cases.index') }}">{{ __('app.nav.cases') }}</a></p>
                </div>
                <div class="footer-section">
                    <h3>{{ __('app.footer.contact') }}</h3>
                    <p>{{ __('app.footer.email') }}</p>
                    <p>{{ __('app.footer.phone') }}</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ __('app.site_name') }}. {{ __('app.footer.rights') }}</p>
            </div>
        </div>
    </footer>
</body>
</html>