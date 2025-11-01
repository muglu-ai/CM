@extends('layouts.public')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    body {
        font-family: "Barlow Condensed", sans-serif!important;
        font-style: normal;
    }
    /* Day Tab Styles */
    #ag .nav-tabs .nav-link {
        color: #fff;
        background-color: #5F3A8C;
        border-color: #dee2e6 #dee2e6 #fff;
        font-family: "Barlow Condensed", sans-serif;
    }
    #ag .nav-tabs .nav-link.active {
        color: #fff;
        background: linear-gradient(to right, #1F296D, #D02560);
    }
    /* Session/Pill Tab Styles */
    #ag .nav-pills-custom .nav-link {
        color: #c81980;
        background: #fff;
        font-weight: bold;
        /* Matches the look of the pills in the image */
        border: 1px solid #e9ecef;
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 15px 10px;
        text-align: left;
        font-family: "Barlow Condensed", sans-serif;
    }
    #ag .nav-pills-custom .nav-link.active {
        color: #fff;
        background: linear-gradient(to right, #2C3A8C, #F72C70);
        font-weight: bold;
        /* Highlight border for active pill */
        border: 1px solid #912e8b;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .bg-white1 {
        background-color: #fff;
    }
    /* Enhanced Agenda Styles - REQUIRED for the image design */
        
    .tab-pane h3 {
        color: #912e8b;
        text-transform: uppercase !important;
        font-weight: 700;
    <?php /*?> border-bottom: 3px solid #b83034;<?php */?> padding-bottom: 10px;
        margin-bottom: 15px;
        font-size: 18px;
        font-family: "Barlow Condensed", sans-serif;
    }
    .pink1 {
        color: #c81980!important;
    }
    .agenda-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 1px solid #e9ecef;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        font-family: "Barlow Condensed", sans-serif;
    }
    .agenda-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 5px;
        height: 100%;
        background: linear-gradient(180deg, #b83034 0%, #071339 100%);
    }
    .agenda-item h4 {
        color: #071339;
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 15px;
        line-height: 1.4;
        font-family: "Barlow Condensed", sans-serif;
    }
    .agenda-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: center;
        font-family: "Barlow Condensed", sans-serif;
    }
    .meta-item {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 8px 15px;
        border-radius: 25px;
        border: 1px solid #e9ecef;
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .meta-item.time {
        background: #2C3A8C;
        color: #fff;
        border-color: #2C3A8C;
    }
    .meta-item.venue {
        background: #5F3A8C;
        color: #fff;
        border-color: #5F3A8C;
        font-family: "Barlow Condensed", sans-serif;
    }
    .meta-item.type {
        background: #007BFF;
        color: #fff;
        border-color: #007BFF;
    }
    .meta-icon {
        width: 16px;
        height: 16px;
        margin-right: 8px;
        opacity: 0.8;
    }
    .session-description {
        color: #444 !important;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-top: 10px;
        font-style: italic;
        font-family: "Barlow Condensed", sans-serif;
    }
    .speaker-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px;
        margin-top: 15px;
        border-left: 3px solid #b83034;
        font-family: "Barlow Condensed", sans-serif;
    }
    .speaker-name {
        font-weight: 600;
        color: #071339;
        margin-bottom: 5px;
        font-family: "Barlow Condensed", sans-serif;
    }
    .speaker-title {
        font-size: 0.875rem;
        color: #6c757d;
        font-family: "Barlow Condensed", sans-serif;
    }
    
    /* --- RESPONSIVE FIXES (NEW) --- */
    @media (max-width: 991.98px) {
    /* Session Pills: Force horizontal scrolling on mobile/tablet */
    #ag .nav-pills-custom {
        flex-direction: row !important; /* Forces pills to be in a row */
        flex-wrap: nowrap; /* Prevents wrapping, forcing scroll */
        overflow-x: auto; /* Enables horizontal scrollbar */
        -webkit-overflow-scrolling: touch;
        padding-bottom: 10px; /* Space for scrollbar */
        margin-bottom: 15px; /* Add margin below pills for separation */
    }
    #ag .nav-pills-custom .nav-link {
        /* Adjust individual pills for horizontal scrolling */
        flex: 0 0 auto;
        min-width: 160px; /* Gives enough width for text */
        margin-right: 10px; /* Space between pills */
        margin-bottom: 0 !important; /* Remove vertical margin when horizontal */
        text-align: center; /* Center text in the horizontal pills */
    }
    /* Day Tabs: Ensure they don't break layout on mobile */
    #dayTabs {
        flex-wrap: nowrap !important;
        overflow-x: auto;
    }
    #dayTabs button {
        flex-shrink: 0;
        min-width: 150px;
    }
    }
    /* Custom CSS class as requested */
    .pg-spk .profile-card {
        /* Ensures consistent vertical spacing and alignment */
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    /* Container for the circular image and its border */
    .pg-spk .circular-image-container {
        /* Define the size of the container (adjust as needed) */
        width: 140px;
        height: 140px;
        padding: 5px;
        /* Create the white/light gray circular border */
        border: 3px solid #e0e0e0;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 5px;
        /* Adding box shadow for the subtle depth effect seen in the original images */
        box-shadow: 0 0 0 1px #e0e0e0;
    }
    /* Styling for the actual image inside the container */
    .pg-spk .circular-image {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Ensures the image covers the area without distortion */
        border-radius: 50%; /* Makes the image itself a circle */
    }
    /* Styling for the text/logo placeholder circle */
    .pg-spk .circular-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-color: #f5f5f5; /* Light gray background */
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .pg-spk .placeholder-text {
        font-size: 2.5rem;
        font-weight: 700;
        color: #bdbdbd; /* Gray color for the text */
    }
    /* Styling for the name */
    .pg-spk .name {
        font-size: 0.8rem; /* Larger font for the name */
        font-weight: 700; /* Bold */
        color: #c81980; /* Dark text color */
        margin-bottom: 0.25rem;
    }
        
        .pg-spk .roll {
        font-size: 0.8rem; /* Larger font for the name */
        font-weight: 700; /* Bold */
        color: #2c3a8c; /* Dark text color */
        margin-bottom: 0rem;
    }
        
        
        
    /* Styling for the title/designation */
    .pg-spk .title {
        font-size: 0.7rem;/* Standard font size */
        color: #444; /* Muted color for the title */
        margin-top: 0;
    }
    
    /* ✅ Mobile (max-width 768px) */
    @media (max-width: 768px) {
    .overflow-auto {
        overflow: auto !important;
    }
    }
    
    /* ✅ Desktop (min-width 769px) */
    @media (min-width: 769px) {
    .overflow-auto {
        overflow: hidden !important;  /* or overflow: none (not valid) */
    }
    }
        
    
        .gradient-btn2 {
          display: inline-block;
          padding: 0.6rem 1.5rem;
          border-radius: 50px;
          font-weight: 500;
          color: #fff;
          background: linear-gradient(to right, #6e00ff, #ff3caa);
          border: none;
          transition: background 0.1s ease-in-out;
        }
    
        .gradient-btn2:hover,
        .gradient-btn2:focus {
          background: linear-gradient(to left, #6e00ff, #ff3caa);
          color: #fff;
        }
    
    
        
        .pink1 {
    color: #c81980 !important;
}
        
        
    </style>

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="container my-4">
        <div class="card" style="border-radius:12px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h3 class="mb-1">Agenda</h3>
                    </div>

                    <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input id="live-search" class="form-control" placeholder="Search sessions or speakers" />
                        </div>
                        <div>
                            <select id="format-filter" class="form-select">
                                <option value="">All formats</option>
                                @foreach($formats as $f)
                                    <option value="{{ $f }}">{{ $f }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Left: tracks nav -->
                    <div class="col-md-3">
                        <div class="list-group" id="tracksList" role="tablist">
                            @foreach($tracks as $idx => $t)
                                <button class="list-group-item list-group-item-action text-start mb-2" data-track-id="{{ $t->id }}" type="button">
                                    {{ $t->name }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Right: days and content -->
                    <div class="col-md-9">
                        <!-- MOBILE: track selector (dropdown) and horizontal pills -->
                        <div class="d-block d-md-none mb-3">
                            <div class="mb-2">
                                <select id="mobileTrackSelect" class="form-select">
                                    <option value="">All tracks</option>
                                    @foreach($tracks as $t)
                                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="mobileTracksPills" class="d-flex gap-2 overflow-auto" style="-webkit-overflow-scrolling:touch;">
                                @foreach($tracks as $t)
                                    <button class="btn btn-sm btn-outline-secondary mobile-track-btn" data-track-id="{{ $t->id }}">{{ $t->name }}</button>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mb-3">
                            <ul class="nav nav-tabs" id="daysTabs" role="tablist">
                                @php $firstDay = true; @endphp
                                @foreach($days as $num => $date)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if($firstDay) active @endif" data-day="day{{ $num }}" type="button">Day {{ $num }} : {{ \Carbon\Carbon::parse($date)->format('d M') }}</button>
                                    </li>
                                    @php $firstDay = false; @endphp
                                @endforeach
                            </ul>
                        </div>

                        {{-- MOBILE: single-column view - per-day accordion of tracks (visible only on small screens) --}}
                        <div class="d-block d-md-none mb-3">
                            <!-- Mobile single-track list (shown when a specific track is selected) -->
                            <div id="mobileTrackList" class="mb-3" style="display:none"></div>

                             @foreach($days as $num => $date)
                                 @php $dayKey = 'day' . $num; @endphp
                                <div class="mobile-day-pane @if($loop->first) active @endif" data-day="day{{ $num }}">
                                    <div class="accordion" id="mobileAccordionDay{{ $num }}">
                                        @foreach($tracks as $t)
                                            @php
                                                $sessionsFor = $allSessions->filter(function($s) use ($t, $dayKey) {
                                                    $sDay = isset($s->event_day) ? strtolower(str_replace(' ', '', $s->event_day)) : '';
                                                    $sDayNormalized = $sDay ? 'day' . preg_replace('/\D/', '', $sDay) : '';
                                                    return (int)($s->track_id ?? 0) === (int)$t->id && ($sDayNormalized === $dayKey || $sDayNormalized === strtolower($dayKey));
                                                });
                                            @endphp

                                            <div class="accordion-item" data-track-id="{{ $t->id }}">
                                                <h2 class="accordion-header" id="heading-{{ $num }}-{{ $t->id }}">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $num }}-{{ $t->id }}" aria-expanded="false" aria-controls="collapse-{{ $num }}-{{ $t->id }}">
                                                        {{ $t->name }} <span class="badge bg-secondary ms-2">{{ $sessionsFor->count() }}</span>
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{ $num }}-{{ $t->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $num }}-{{ $t->id }}" data-bs-parent="#mobileAccordionDay{{ $num }}">
                                                    <div class="accordion-body">
                                                        @if($sessionsFor->isEmpty())
                                                            <div class="text-muted">No sessions for this track and day.</div>
                                                        @else
                                                            @foreach($sessionsFor as $session)
                                                                @php $sid = 's' . $session->id . '-' . $num; @endphp
                                                                <div class="mb-2">
                                                                    <div class="d-flex justify-content-between align-items-center">
                                                                        <div>
                                                                            <button class="btn btn-link p-0 text-decoration-none" data-bs-toggle="collapse" data-bs-target="#collapse-session-{{ $sid }}" aria-expanded="false" aria-controls="collapse-session-{{ $sid }}">
                                                                                <strong class="text-dark">{{ $session->title }}</strong>
                                                                            </button>
                                                                            <div class="agenda-meta">
                                                                            <div class="meta-item time"><svg class="meta-icon" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                                              </svg>
                                                                              {{ $session->starts_at ? $session->starts_at->format('M d, H:i') : '' }} - {{ $session->ends_at ? $session->ends_at->format('M d, H:i') : '' }}</div>
                                                                            <div class="meta-item venue"><svg class="meta-icon" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                                              </svg>
                                                                            {{ $session->location ?? '—' }}</div>
                                                                        </div>
                                                                        </div>
                                                                        <div>
                                                                            <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#collapse-session-{{ $sid }}">Details</button>
                                                                        </div>
                                                                    </div>

                                                                    <div id="collapse-session-{{ $sid }}" class="collapse mt-2">
                                                                        <div class="card card-body py-2">
                                                                            <div class="session-description">{{ \Illuminate\Support\Str::limit($session->description ?? '', 400) }}</div>
                                                                            <div>
                                                                                <strong>Speakers</strong>
                                                                                
                                                                                <ul class="list-unstyled mb-0 small">
                                                                                    @foreach($session->speakers as $speaker)
                                                                                        <li class="mb-1" style="list-style: none;">
                                                                                            <div class="profile-card">
                                                                                                <div class="circular-image-container mb-2">
                                                                                                    <img src="{{ $speaker->image_path }}" alt="{{ $speaker->name }}" class="img-fluid circular-image">
                                                                                                    {{-- @dd($speaker->image_path) --}}
                                                                                                    {{-- @dd($speaker) --}}
                                                                                                    {{-- @if(!empty($speaker->image_path)) --}}
                                                                                                        {{-- <img src="{{ $speaker->image_path }}" alt="{{ $speaker->name }}" class="img-fluid circular-image"> --}}
                                                                                                    {{-- @else --}}
                                                                                                        {{-- <div class="circular-placeholder"> --}}
                                                                                                            {{-- <span class="placeholder-text">{{ strtoupper(mb_substr($speaker->name, 0, 1)) }}</span> --}}
                                                                                                        {{-- </div> --}}
                                                                                                    {{-- @endif --}}
                                                                                                </div>
                                                                                                <h5 class="name mb-0">{{ $speaker->name }}</h5>
                                                                                                @if($speaker->pivot->role)
                                                                                                    <p class="title text-muted mb-1" style="font-size:0.9em;">{{ $speaker->pivot->role }}</p>
                                                                                                @endif
                                                                                                <p style="margin-bottom: 0;">
                                                                                                    <a href="#" target="_blank" class="btn gradient-btn2 rounded-pill py-1 px-3 ms-0 mt-1 mb-0">Profile</a>
                                                                                                </p>
                                                                                            </div>
                                                                                        </li>
                                                                                    @endforeach
                                                                                </ul>

                                                                               
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- end mobile panes -->

                        @php
                             // Prefer the controller-provided full collection ($allSessions); fall back to the paginated collection if needed
                             if (! isset($allSessions)) {
                                 $allSessions = $sessions instanceof \Illuminate\Pagination\LengthAwarePaginator ? $sessions->getCollection() : $sessions;
                             }
                         @endphp

                         <div id="tracksContent">
                            @foreach($tracks as $tIdx => $t)
                                @php $isFirstTrack = $tIdx === 0; @endphp
                                <div class="track-pane  @if($isFirstTrack) active @endif" data-track-id="{{ $t->id }}">

                                    @foreach($days as $num => $date)
                                        @php
                                            $dayKey = 'day' . $num;
                                            $sessionsFor = $allSessions->filter(function($s) use ($t, $dayKey) {
                                                $sDay = isset($s->event_day) ? strtolower(str_replace(' ', '', $s->event_day)) : '';
                                                $sDayNormalized = $sDay ? 'day' . preg_replace('/\D/', '', $sDay) : '';
                                                return (int)($s->track_id ?? 0) === (int)$t->id && ($sDayNormalized === $dayKey || $sDayNormalized === strtolower($dayKey));
                                            });
                                        @endphp

                                        <div class="day-pane  pink1 mb-1 pb-1 @if($loop->first) active @endif" data-day="day{{ $num }}">
                                            <div class="mb-3">
                                                {{-- <h4 class="mb-1 text-primary">{{ $t->name }} - Day {{ $num }}</h4> --}}
                                                <h4 class="mb-1 text-primary mb-1 pb-1">{{ strtoupper($t->name) }} </h4>
                                                {{-- <p class="text-muted"> Day {{ $num }} Content</p> --}}
                                            </div>

                                            @if($sessionsFor->isEmpty())
                                                <div class="alert alert-light">No sessions for this track and day.</div>
                                            @else
                                                <div class="row g-3 session-list ">
                                                    @foreach($sessionsFor as $session)
                                                        <div class="col-12 session-card ">
                                                            <div class="">
                                                                <div class="agenda-item d-flex flex-column flex-md-row justify-content-between">
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex align-items-center gap-2 mb-2">
                                                                            {{-- @if(optional($session->event)->name)
                                                                                <span class="badge bg-light text-dark">{{ optional($session->event)->name }}</span>
                                                                            @endif --}}
                                                                            {{-- @if($session->event_day)
                                                                                <span class="badge bg-primary text-white">{{ ucfirst($session->event_day) }}</span>
                                                                            @endif --}}
                                                                            {{-- @if($session->format)
                                                                                <span class="badge bg-success">{{ $session->format }}</span>
                                                                            @endif
                                                                            @if($session->level)
                                                                                <span class="badge bg-warning text-dark">{{ $session->level }}</span>
                                                                            @endif --}}
                                                                        </div>

                                                                        <h5 class="card-title mb-1 pink1">{{ $session->title }}</h5>
                                                                        {{-- <p class="mb-2 text-muted small">{{ collect([optional($session->event)->name, $session->format, $session->level, optional($session->track)->name])->filter()->implode(' • ') }}</p> --}}
                                                                        {{-- <div class="text-md-end ms-md-3 mt-3 mt-md-0" style="min-width:130px;">
                                                                            <div class="fw-semibold">{{ $session->starts_at ? $session->starts_at->format('M d, H:i') : '' }}</div>
                                                                            <div class="small">Room: <span class="fw-semibold">{{ $session->room ?? '—' }}</span></div>
                                                                        </div> --}}
                                                                        <div>
                                                                            {{-- <button class="btn btn-link p-0 text-decoration-none" data-bs-toggle="collapse" data-bs-target="#collapse-session-{{ $sid }}" aria-expanded="false" aria-controls="collapse-session-{{ $sid }}">
                                                                                <strong class="text-dark">{{ $session->title }}</strong>
                                                                            </button> --}}
                                                                            <div class="agenda-meta">
                                                                            <div class="meta-item time"><svg class="meta-icon" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                                              </svg>
                                                                              {{ $session->starts_at ? $session->starts_at->format('M d, H:i') : '' }} - {{ $session->ends_at ? $session->ends_at->format('M d, H:i') : '' }}</div>
                                                                            <div class="meta-item venue"><svg class="meta-icon" fill="currentColor" viewBox="0 0 20 20">
                                                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                                              </svg>
                                                                            {{ $session->location ?? '—' }}</div>
                                                                        </div>
                                                                        <p class="mb-2">{{ $session->description }}</p>

                                                                        <div class="mt-2">
                                                                            {{-- <strong>Speakers</strong> --}}
                                                                            <div class="row g-4 pg-spk">
                                                                                @foreach($session->speakers as $speaker)
                                                                                    @php
                                                                                        $parts = preg_split('/\\s+/', trim($speaker->name));
                                                                                        $initials = strtoupper(substr($parts[0] ?? '', 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
                                                                                    @endphp
                                                                                    <div class="col-12 col-md-6 col-lg-3 text-center">
                                                                                        <div class="profile-card">
                                                                                            <div class="circular-image-container mb-3">
                                                                                                @if(!empty($speaker->image_path))
                                                                                                    <img src="{{ $speaker->image_path }}" alt="{{ $speaker->name }}" class="img-fluid circular-image">
                                                                                                @else
                                                                                                    <div class="circular-placeholder">
                                                                                                        <span class="placeholder-text">{{ $initials }}</span>
                                                                                                    </div>
                                                                                                @endif
                                                                                            </div>
                                                                                            <h5 class="name">{{ $speaker->name }}</h5>
                                                                                            @if($speaker->title)
                                                                                                <p class="title">{{ $speaker->title }}</p>
                                                                                            @endif
                                                                                            @if($speaker->company)
                                                                                            <p class="title">{{ $speaker->company }}</p>
                                                                                        @endif
                                                                                            {{-- Optionally, add a profile button if there's a URL --}}
                                                                                            @if(!empty($speaker->linkedin))
                                                                                                <p>
                                                                                                    <a href="{{ $speaker->linkedin }}" target="_blank" class="btn gradient-btn2 rounded-pill py-1 px-4 ms-0 mt-0 mb-2">
                                                                                                        Profile
                                                                                                    </a>
                                                                                                </p>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                    @endforeach

                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3 d-flex justify-content-center">{{ $sessions->links('pagination::bootstrap-5') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Slight visual tweaks to match requested design */
        /* Left track cards */
        #tracksList { padding: 8px; }
        #tracksList .list-group-item {
            border-radius:10px;
            background: #ffffff;
            border: 1px solid #eef1f5;
            padding: 18px 14px;
            font-weight:700;
            color:#c81980;
            box-shadow: 0 1px 2px rgba(16,24,40,0.03);
        }
        #tracksList .list-group-item + .list-group-item { margin-top: 12px; }

        /* Active track style - gradient pill */
        #tracksList .list-group-item.active {
            background: linear-gradient(90deg,#2C3A8C 0%, #F72C70 100%);
            color: #fff;
            box-shadow: 0 6px 18px rgba(39,24,83,0.15);
            border: none;
            transform: translateY(-2px);
        }

        /* Right content background to match sample (light gray area) */
        .card-body { background: #f4f6f8; border-radius:8px; }
        /* Inner white panel for the active day content */
        .day-pane { padding: 18px; }
        .day-pane > .mb-3 { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 6px rgba(16,24,40,0.04); }

        /* Session card visual */
        .session-card .card { border: 1px solid #edf2f7; border-radius:8px; }
        .session-card .card-body { background: #fff; }

        /* Pill style day tabs on the right */
        #daysTabs { gap:8px; }
        #daysTabs .nav-link {
            border-radius: 20px;
            background: linear-gradient(90deg,#5f3a8c,#c81980);
            color: #fff;
            padding: 8px 16px;
            margin-left:6px;
            box-shadow: 0 4px 12px rgba(39,24,83,0.12);
        }
        #daysTabs .nav-link:not(.active) {
            opacity: 0.85;
            background: #6b2f7a;
        }

        /* Mobile-specific track pills */
        .mobile-track-btn { white-space: nowrap; flex: 0 0 auto; border-radius: 18px; }
        .mobile-track-btn.active { background: linear-gradient(90deg,#2C3A8C,#F72C70); color: #fff; border-color: transparent; }

        /* make left column scrollable if many tracks */
        @media(min-width: 768px){
            #tracksList { max-height: 80vh; overflow:auto; padding-right:6px; }
        }

        /* Pane visibility controlled with classes for predictable JS */
        .track-pane { display:none; }
        .track-pane.active { display:block; }
        .day-pane { display:none; }
        .day-pane.active { display:block; }
        /* Mobile day panes (accordion per day) */
        .mobile-day-pane { display:none; }
        .mobile-day-pane.active { display:block; }

        /* small screens tweaks */
        @media(max-width: 767.98px){
            #tracksList { display:flex; gap:10px; overflow:auto; }
            #tracksList .list-group-item { min-width: 160px; flex:0 0 auto; }
            #daysTabs { justify-content:flex-start; }
        }
    </style>

    <script>
        (function(){
            const tracksList = document.getElementById('tracksList');
            const mobileTrackSelect = document.getElementById('mobileTrackSelect');
            const mobileTrackBtns = Array.from(document.querySelectorAll('.mobile-track-btn'));
            const dayButtons = Array.from(document.querySelectorAll('#daysTabs .nav-link'));
            const tracksContent = document.getElementById('tracksContent');
            const search = document.getElementById('live-search');
            const formatFilter = document.getElementById('format-filter');

            // Initial active selections
            let activeTrackId = tracksList.querySelector('[data-track-id]') ? tracksList.querySelector('[data-track-id]').getAttribute('data-track-id') : null;
            let activeDay = dayButtons.length ? dayButtons[0].getAttribute('data-day') : null;

            // Helper: find active track pane
            function getActiveTrackPane(){
                return tracksContent.querySelector('.track-pane.active');
            }

            // Activate a given track id (by toggling active classes)
            function activateTrack(trackId){
                // buttons (desktop)
                Array.from(tracksList.querySelectorAll('[data-track-id]')).forEach(b => b.classList.toggle('active', b.getAttribute('data-track-id') === String(trackId)));
                // mobile select
                if(mobileTrackSelect) mobileTrackSelect.value = trackId || '';
                // mobile pills
                mobileTrackBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-track-id') === String(trackId)));
                // panes
                Array.from(tracksContent.querySelectorAll('.track-pane')).forEach(p => p.classList.toggle('active', p.getAttribute('data-track-id') === String(trackId)));

                // ensure the active day pane is visible inside the active track
                const pane = getActiveTrackPane();
                if(pane){
                    const dayPaneToShow = pane.querySelector('.day-pane[data-day="' + activeDay + '"]') || pane.querySelector('.day-pane');
                    pane.querySelectorAll('.day-pane').forEach(dp => dp.classList.remove('active'));
                    if(dayPaneToShow) dayPaneToShow.classList.add('active');
                }
            }

            // Activate a given day globally
            function activateDay(dayKey){
                activeDay = dayKey;
                dayButtons.forEach(b => b.classList.toggle('active', b.getAttribute('data-day') === dayKey));
                const pane = getActiveTrackPane();
                if(pane){
                    pane.querySelectorAll('.day-pane').forEach(dp => dp.classList.toggle('active', dp.getAttribute('data-day') === dayKey));
                }
                // also toggle mobile-day-pane visibility
                Array.from(document.querySelectorAll('.mobile-day-pane')).forEach(md => md.classList.toggle('active', md.getAttribute('data-day') === dayKey));
            }

            // Setup desktop track buttons
            Array.from(tracksList.querySelectorAll('[data-track-id]')).forEach(btn => {
                btn.addEventListener('click', function(){
                    activeTrackId = this.getAttribute('data-track-id');
                    activateTrack(activeTrackId);
                    filterVisibleSessions();
                });
            });

            // Setup mobile track select (dropdown)
            if(mobileTrackSelect){
                mobileTrackSelect.addEventListener('change', function(){
                    const val = this.value || null;
                    activeTrackId = val;
                    activateTrack(activeTrackId);
                    updateMobileAccordions();
                    filterVisibleSessions();
                });
            }

            // Setup mobile track pills
            mobileTrackBtns.forEach(btn => btn.addEventListener('click', function(){
                const id = this.getAttribute('data-track-id');
                activeTrackId = id;
                activateTrack(activeTrackId);
                updateMobileAccordions();
                filterVisibleSessions();
            }));

            // Show/hide mobile accordion items when a specific track is selected on mobile
            function updateMobileAccordions(){
                // if no mobile elements, skip
                const mobilePanes = Array.from(document.querySelectorAll('.mobile-day-pane'));
                if(!mobilePanes.length) return;

                mobilePanes.forEach(pane => {
                    const items = Array.from(pane.querySelectorAll('.accordion-item'));
                    items.forEach(item => {
                        const tid = item.getAttribute('data-track-id');
                        if(!activeTrackId || String(activeTrackId) === '' ){
                            item.style.display = ''; // show all
                        } else {
                            item.style.display = (String(tid) === String(activeTrackId)) ? '' : 'none';
                            // if hiding, ensure collapse inside is closed
                            if(String(tid) !== String(activeTrackId)){
                                const collapse = item.querySelector('.accordion-collapse');
                                if(collapse && collapse.classList.contains('show')){
                                    // using bootstrap's collapse if available
                                    try{ var bs = bootstrap.Collapse.getInstance(collapse); if(bs) bs.hide(); }catch(e){}
                                }
                            }
                        }
                    });
                });

                // toggle between accordion view and single-track list on mobile
                const mobileTrackList = document.getElementById('mobileTrackList');
                if(!mobileTrackList) return;
                if(!activeTrackId || String(activeTrackId) === ''){
                    // show accordion, hide single-track list
                    mobileTrackList.style.display = 'none';
                    mobilePanes.forEach(p => p.style.display = 'block');
                } else {
                    // hide accordion panes and show single-track list
                    mobilePanes.forEach(p => p.style.display = 'none');
                    mobileTrackList.style.display = 'block';
                    // render content for active track/day into mobileTrackList
                    renderMobileTrackList();
                }
            }

            // Render the currently active track/day sessions into the mobileTrackList container
            function renderMobileTrackList(){
                const mobileTrackList = document.getElementById('mobileTrackList');
                if(!mobileTrackList) return;
                const pane = getActiveTrackPane();
                if(!pane) { mobileTrackList.innerHTML = '<div class="text-muted">No sessions</div>'; return; }
                const visibleDayPane = pane.querySelector('.day-pane.active');
                if(!visibleDayPane) { mobileTrackList.innerHTML = '<div class="text-muted">No sessions for this day</div>'; return; }
                // clone the inner content of visibleDayPane's session-list (or entire day pane)
                const list = visibleDayPane.querySelector('.session-list');
                if(list){
                    mobileTrackList.innerHTML = list.outerHTML;
                } else {
                    mobileTrackList.innerHTML = visibleDayPane.innerHTML;
                }
            }

             // Mark first track active on load
             const firstTrackBtn = tracksList.querySelector('[data-track-id]');
             if(firstTrackBtn){
                 activeTrackId = firstTrackBtn.getAttribute('data-track-id');
                 activateTrack(activeTrackId);
             }

             // ensure mobile accordions reflect the initial active track
             updateMobileAccordions();
             // also render initial mobile single-track list if applicable
             renderMobileTrackList();

            // Day tabs listeners
            dayButtons.forEach(btn => btn.addEventListener('click', function(){
                activateDay(this.getAttribute('data-day'));
                filterVisibleSessions();
            }));

            // Search debounce
            let debounce;
            if(search){
                search.addEventListener('input', function(){
                    clearTimeout(debounce);
                    debounce = setTimeout(filterVisibleSessions, 300);
                });
            }

            if(formatFilter){
                formatFilter.addEventListener('change', filterVisibleSessions);
            }

            function filterVisibleSessions(){
                const pane = getActiveTrackPane();
                if(!pane) return;
                const visibleDayPane = pane.querySelector('.day-pane.active');
                if(!visibleDayPane) return;

                const q = (search && search.value) ? search.value.trim().toLowerCase() : '';
                const formatVal = (formatFilter && formatFilter.value) ? formatFilter.value.toLowerCase() : '';

                Array.from(visibleDayPane.querySelectorAll('.session-card')).forEach(cardWrap => {
                    const card = cardWrap.querySelector('.card');
                    if(!card) return;
                    const text = card.textContent.toLowerCase();
                    const matchesQ = !q || text.includes(q);
                    const matchesFormat = !formatVal || text.includes(formatVal);
                    cardWrap.style.display = (matchesQ && matchesFormat) ? '' : 'none';
                });
            }

            // Apply initial day selection (first day)
            if(dayButtons.length) activateDay(dayButtons[0].getAttribute('data-day'));

            // initial filter
            filterVisibleSessions();
        })();
    </script>
@endsection
