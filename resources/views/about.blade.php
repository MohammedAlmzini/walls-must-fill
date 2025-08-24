@extends('layouts.seo')

@section('title', __('app.nav.about') . ' - ' . __('app.site_name'))

@section('content')
<main id="main-content">
    <div class="container">
        <article class="about-page">
            <header class="page-header">
                <h1>{{ __('app.nav.about') }}</h1>
                <p class="lead">{{ __('app.description') }}</p>
            </header>

            <section class="content">
                <h2>{{ __('app.about.mission_title') }}</h2>
                <p>{{ __('app.about.mission_text') }}</p>
                <ul>
                    <li>{{ __('app.about.mission_point1') }}</li>
                    <li>{{ __('app.about.mission_point2') }}</li>
                    <li>{{ __('app.about.mission_point3') }}</li>
                    <li>{{ __('app.about.mission_point4') }}</li>
                </ul>

                <h2>{{ __('app.about.values_title') }}</h2>
                <div class="values-grid">
                    <div class="value-item">
                        <h3>{{ __('app.about.value1_title') }}</h3>
                        <p>{{ __('app.about.value1_text') }}</p>
                    </div>
                    <div class="value-item">
                        <h3>{{ __('app.about.value2_title') }}</h3>
                        <p>{{ __('app.about.value2_text') }}</p>
                    </div>
                    <div class="value-item">
                        <h3>{{ __('app.about.value3_title') }}</h3>
                        <p>{{ __('app.about.value3_text') }}</p>
                    </div>
                </div>

                <h2>{{ __('app.about.how_we_work_title') }}</h2>
                <p>{{ __('app.about.how_we_work_text') }}</p>
            </section>
        </article>
    </div>
</main>

<style>
.about-page {
    max-width: 800px;
    margin: 40px auto;
    padding: 0 20px;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 20px;
    border-bottom: 2px solid var(--border);
}

.lead {
    font-size: 1.2rem;
    color: var(--muted);
    margin-top: 10px;
}

.content h2 {
    color: var(--brand-red);
    border-bottom: 2px solid var(--brand-red);
    padding-bottom: 5px;
    margin-top: 40px;
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.value-item {
    padding: 20px;
    background: var(--surface);
    border-radius: var(--radius);
    border: 1px solid var(--border);
    transition: all 0.3s ease;
}

.value-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.value-item h3 {
    color: var(--brand-red);
    margin-bottom: 10px;
}

ul {
    list-style: none;
    padding: 0;
}

ul li {
    padding: 8px 0;
    padding-right: 20px;
    position: relative;
}

ul li:before {
    content: '•';
    color: var(--brand-red);
    font-weight: bold;
    position: absolute;
    right: 0;
}

@media (max-width: 768px) {
    .about-page {
        margin: 20px auto;
        padding: 0 15px;
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
}

ul li:before {
    content: "✓";
    color: var(--green);
    font-weight: bold;
    position: absolute;
    right: 0;
}
</style>
@endsection