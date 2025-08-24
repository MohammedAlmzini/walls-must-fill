@extends('layouts.seo')

@section('title', __('app.sections.urgent_appeals') . ' -- ' . __('app.site_name'))

@section('content')
    <h1 class="section-title" style="margin-top:0">{{ __('app.sections.urgent_appeals') }}</h1>

    <form method="get" style="margin:12px 0;">
        <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('app.forms.search_case_placeholder') }}"
               style="width:100%;max-width:420px;padding:12px 14px;border:1px solid var(--border);border-radius:999px;outline:none;box-shadow:none"
               onfocus="this.style.boxShadow='var(--focus)';" onblur="this.style.boxShadow='none'">
    </form>

    <div class="grid grid-3">
        @forelse($cases as $case)
            <article class="card clickable-card" onclick="window.location.href='{{ route('cases.show', $case->slug) }}'">
                @if($case->cover_image_path)
                    <img src="{{ asset('storage/'.$case->cover_image_path) }}" alt="{{ $case->title }}">
                @endif
                <div class="p">
                    <h3 style="margin:0 0 6px">{{ $case->title }}</h3>
                    <p class="muted">{{ __('app.amount_of.collected') }}: ${{ number_format($case->collected_amount,2) }} {{ __('app.amount_of.from') }} {{ $case->goal_amount ? '$'.number_format($case->goal_amount,2) : __('app.amount_of.no_goal_set') }}</p>
                    @if($case->is_completed)
                        <span class="badge">{{ __('app.messages.case_completed') }} ✅</span>
                    @endif
                </div>
            </article>
        @empty
            <p class="muted">{{ __('app.empty_states.no_cases') }}</p>
        @endforelse
    </div>

    <div style="margin-top:16px">
        {{ $cases->withQueryString()->links() }}
    </div>
@endsection