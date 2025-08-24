@extends('admin.layouts.admin')

@section('title', 'معاينة إعدادات SEO')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">معاينة إعدادات SEO</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.seo.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right"></i> العودة للقائمة
                        </a>
                        <a href="{{ route('admin.seo.edit', $seoSetting) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> تعديل
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>معلومات الصفحة</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>الصفحة:</th>
                                    <td>{{ $availablePages[$pageKey] ?? $pageKey }}</td>
                                </tr>
                                <tr>
                                    <th>اللغة:</th>
                                    <td>{{ $availableLocales[$locale] ?? $locale }}</td>
                                </tr>
                                <tr>
                                    <th>الحالة:</th>
                                    <td>
                                        @if($seoSetting->is_active)
                                            <span class="badge badge-success">مفعل</span>
                                        @else
                                            <span class="badge badge-secondary">معطل</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>الإعدادات الأساسية</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>العنوان:</th>
                                    <td>{{ $seoSetting->title }}</td>
                                </tr>
                                <tr>
                                    <th>الوصف:</th>
                                    <td>{{ $seoSetting->description }}</td>
                                </tr>
                                <tr>
                                    <th>الكلمات المفتاحية:</th>
                                    <td>{{ $seoSetting->keywords ?: 'غير محدد' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>إعدادات Open Graph (Facebook)</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>العنوان:</th>
                                    <td>{{ $seoSetting->og_title ?: $seoSetting->title }}</td>
                                </tr>
                                <tr>
                                    <th>الوصف:</th>
                                    <td>{{ $seoSetting->og_description ?: $seoSetting->description }}</td>
                                </tr>
                                <tr>
                                    <th>الصورة:</th>
                                    <td>
                                        @if($seoSetting->og_image)
                                            <img src="{{ asset('storage/' . $seoSetting->og_image) }}" 
                                                 alt="صورة Open Graph" class="img-thumbnail" style="max-width: 150px;">
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>إعدادات Twitter Card</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>العنوان:</th>
                                    <td>{{ $seoSetting->twitter_title ?: $seoSetting->title }}</td>
                                </tr>
                                <tr>
                                    <th>الوصف:</th>
                                    <td>{{ $seoSetting->twitter_description ?: $seoSetting->description }}</td>
                                </tr>
                                <tr>
                                    <th>الصورة:</th>
                                    <td>
                                        @if($seoSetting->twitter_image)
                                            <img src="{{ asset('storage/' . $seoSetting->twitter_image) }}" 
                                                 alt="صورة Twitter" class="img-thumbnail" style="max-width: 150px;">
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h5>معاينة HTML Meta Tags</h5>
                    <div class="bg-light p-3 rounded">
                        <pre><code>&lt;title&gt;{{ $meta['title'] }}&lt;/title&gt;
&lt;meta name="description" content="{{ $meta['description'] }}"&gt;
@if($meta['keywords'])
&lt;meta name="keywords" content="{{ $meta['keywords'] }}"&gt;
@endif

&lt;!-- Open Graph / Facebook --&gt;
&lt;meta property="og:type" content="{{ $meta['type'] }}"&gt;
&lt;meta property="og:url" content="{{ $meta['url'] }}"&gt;
&lt;meta property="og:title" content="{{ $meta['og_title'] ?? $meta['title'] }}"&gt;
&lt;meta property="og:description" content="{{ $meta['og_description'] ?? $meta['description'] }}"&gt;
@if($meta['og_image'])
&lt;meta property="og:image" content="{{ $meta['og_image'] }}"&gt;
@endif

&lt;!-- Twitter --&gt;
&lt;meta property="twitter:card" content="summary_large_image"&gt;
&lt;meta property="twitter:url" content="{{ $meta['url'] }}"&gt;
&lt;meta property="twitter:title" content="{{ $meta['twitter_title'] ?? $meta['title'] }}"&gt;
&lt;meta property="twitter:description" content="{{ $meta['twitter_description'] ?? $meta['description'] }}"&gt;
@if($meta['twitter_image'])
&lt;meta property="twitter:image" content="{{ $meta['twitter_image'] }}"&gt;
@endif</code></pre>
                    </div>

                    @if($meta['structured_data'])
                    <hr>
                    <h5>Structured Data (Schema.org)</h5>
                    <div class="bg-light p-3 rounded">
                        <pre><code>&lt;script type="application/ld+json"&gt;
{{ json_encode($meta['structured_data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
&lt;/script&gt;</code></pre>
                    </div>
                    @endif

                    <hr>
                    <h5>معاينة مشاركة وسائل التواصل الاجتماعي</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Facebook / Open Graph</h6>
                            <div class="border rounded p-3">
                                @if($meta['og_image'])
                                    <img src="{{ $meta['og_image'] }}" alt="صورة المشاركة" class="img-fluid mb-2" style="max-width: 100%;">
                                @endif
                                <h6 class="mb-1">{{ $meta['og_title'] ?? $meta['title'] }}</h6>
                                <p class="text-muted small mb-1">{{ $meta['og_description'] ?? $meta['description'] }}</p>
                                <small class="text-muted">{{ parse_url($meta['url'], PHP_URL_HOST) }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6>Twitter Card</h6>
                            <div class="border rounded p-3">
                                @if($meta['twitter_image'])
                                    <img src="{{ $meta['twitter_image'] }}" alt="صورة المشاركة" class="img-fluid mb-2" style="max-width: 100%;">
                                @endif
                                <h6 class="mb-1">{{ $meta['twitter_title'] ?? $meta['title'] }}</h6>
                                <p class="text-muted small mb-1">{{ $meta['twitter_description'] ?? $meta['description'] }}</p>
                                <small class="text-muted">{{ parse_url($meta['url'], PHP_URL_HOST) }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $availablePages = \App\Services\SEOService::getAvailablePages();
@endphp

@endsection
