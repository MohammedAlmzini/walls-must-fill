<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - Walls Must</title>
    <style>
        :root {
            --primary-color: #2563eb;
            --secondary-color: #3b82f6;
            --danger-color: #ef4444;
            --success-color: #10b981;
            --background-color: #f1f5f9;
            --sidebar-color: #1e293b;
            --text-color: #1e293b;
            --border-color: #e2e8f0;
            --card-color: #ffffff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', 'Tahoma', sans-serif;
        }
        
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
        }
        
        .admin-container {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: var(--sidebar-color);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            transition: all 0.3s ease;
        }
        
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h2 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }
        
        .sidebar-menu {
            padding: 15px 0;
        }
        
        .menu-item {
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }
        
        .menu-item:hover, .menu-item.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .menu-item i {
            margin-left: 10px;
            font-size: 1.2rem;
            width: 20px;
            text-align: center;
        }
        
        .main-content {
            flex-grow: 1;
            margin-right: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }
        
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        .box {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
        }
        
        .btn.secondary {
            background-color: #64748b;
        }
        
        .btn.secondary:hover {
            background-color: #475569;
        }
        
        .btn.danger {
            background-color: var(--danger-color);
        }
        
        .btn.danger:hover {
            background-color: #dc2626;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 12px 15px;
            text-align: right;
            border-bottom: 1px solid var(--border-color);
        }
        
        table th {
            background-color: #f8fafc;
            font-weight: 600;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        input[type="text"], input[type="url"], input[type="email"], input[type="number"], input[type="password"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 0.9rem;
        }
        
        input[type="file"] {
            margin-bottom: 15px;
        }
        
        .alert {
            padding: 12px 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-right: 4px solid;
        }
        
        .alert-success {
            background-color: #ecfdf5;
            border-color: var(--success-color);
            color: #065f46;
        }
        
        .alert-error {
            background-color: #fef2f2;
            border-color: var(--danger-color);
            color: #991b1b;
        }
        
        /* حمّل الأيقونات من Font Awesome أو أي مكتبة مشابهة */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css');
        
        /* ستايلات للشاشات الصغيرة */
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }
            
            .sidebar.active {
                width: 250px;
            }
            
            .main-content {
                margin-right: 0;
            }
            
            .menu-toggle {
                display: block;
                position: fixed;
                top: 10px;
                right: 10px;
                z-index: 1000;
                background-color: var(--primary-color);
                color: white;
                border: none;
                border-radius: 4px;
                padding: 8px 12px;
                cursor: pointer;
            }
        }
        
        /* إضافة الستايلات الخاصة بالإحصائيات */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background-color: var(--card-color);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card .stat-title {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        .stat-card .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }
        
        .stat-card .stat-icon {
            margin-bottom: 10px;
            color: var(--primary-color);
            font-size: 2rem;
            align-self: flex-start;
        }
        
        .stat-card.post-stat { border-top: 3px solid #3b82f6; }
        .stat-card.case-stat { border-top: 3px solid #10b981; }
        .stat-card.complete-stat { border-top: 3px solid #f59e0b; }
        .stat-card.donation-stat { border-top: 3px solid #ef4444; }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- القائمة الجانبية -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Walls Must</h2>
                <div>لوحة التحكم</div>
            </div>
            <nav class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    الرئيسية
                </a>
                <a href="{{ route('admin.posts.index') }}" class="menu-item {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    التدوينات
                </a>
                <a href="{{ route('admin.cases.index') }}" class="menu-item {{ request()->routeIs('admin.cases.*') ? 'active' : '' }}">
                    <i class="fas fa-hands-helping"></i>
                    الحالات
                </a>
                <a href="{{ route('admin.messages.index') }}" class="menu-item {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    الرسائل
                </a>
                <a href="{{ route('admin.main-campaign.index') }}" class="menu-item {{ request()->routeIs('admin.main-campaign.*') ? 'active' : '' }}">
                    <i class="fas fa-flag"></i>
                    الحملة الرئيسية
                </a>
                <form action="{{ route('admin.logout') }}" method="post" style="margin-top: 20px;">
                    @csrf
                    <button type="submit" class="menu-item" style="width: 100%; text-align: right; border: none; background: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i>
                        تسجيل الخروج
                    </button>
                </form>
            </nav>
        </aside>

        <!-- المحتوى الرئيسي -->
        <main class="main-content">
            <!-- زر قائمة للموبايل -->
            <button class="menu-toggle" id="menuToggle" style="display: none;">
                <i class="fas fa-bars"></i>
            </button>

            <!-- رسائل النظام -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            <!-- المحتوى المتغير -->
            @yield('content')
        </main>
    </div>

    <script>
        // سكريبت للتبديل بين إظهار وإخفاء القائمة الجانبية في الموبايل
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (window.innerWidth <= 768) {
                menuToggle.style.display = 'block';
            }
            
            window.addEventListener('resize', function() {
                if (window.innerWidth <= 768) {
                    menuToggle.style.display = 'block';
                } else {
                    menuToggle.style.display = 'none';
                    sidebar.classList.add('active');
                }
            });
            
            menuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        });
    </script>
</body>
</html>