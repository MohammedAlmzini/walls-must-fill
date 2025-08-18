@extends('layouts.app')

@section('title', __('app.nav.about') . ' - ' . __('app.site_name'))

@section('content')
<div class="card" style="margin-top:0">
    <div class="p">
        <div style="text-align:center;margin-bottom:22px">
            <h1 style="margin:0 0 8px">{{ __('app.nav.about') }}</h1>
            <p class="muted" style="margin:0">{{ __('app.tagline') }}</p>
        </div>

        <div class="grid" style="gap:20px">
            <section class="card"><div class="p">
                <h2 style="margin:0 0 8px">{{ __('app.footer.description') }}</h2>
                <p class="muted" style="margin:0">{{ __('app.footer.belief') }}</p>
            </div></section>

            <section class="card"><div class="p">
                <h2 style="margin:0 0 8px">{{ __('app.footer.independence') }}</h2>
                <p class="muted" style="margin:0">{{ __('app.footer.description') }}</p>
            </div></section>

            <section class="card"><div class="p">
                <h2 style="margin:0 0 8px">{{ __('app.footer.transparency') }}</h2>
                <p class="muted" style="margin:0">{{ __('app.footer.description') }}</p>
            </div></section>

            <section class="card"><div class="p">
                <h2 style="margin:0 0 8px">{{ __('app.footer.urgent_response') }}</h2>
                <p class="muted" style="margin:0">{{ __('app.footer.description') }}</p>
            </div></section>
        </div>

        <div style="margin-top:24px;text-align:center;border-top:1px solid var(--border);padding-top:20px">
            <h3 style="margin:0 0 8px">{{ __('app.buttons.support_now') }}</h3>
            <p class="muted" style="margin:0 0 12px">{{ __('app.footer.description') }}</p>
            <a href="{{ route('cases.index') }}" class="btn btn-primary">{{ __('app.buttons.explore_appeals') }}</a>
        </div>
    </div>
</div>
@endsection