@extends('layouts.public')



@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="container my-4">
        <div class="card" style="border-radius:12px;">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    {{-- <div>
                        <h3 class="mb-1">Agenda</h3>
                    </div> --}}

                    {{-- <div class="d-flex gap-2 align-items-center">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input id="live-search" class="form-control" placeholder="Search sessions or speakers" />
                        </div>
                        <div>
                            <select id="format-filter" class="form-select">
                                <option value="">All formats</option>
                                @foreach ($formats as $f)
                                    <option value="{{ $f }}">{{ $f }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
                </div>

                <div class="row">
                    <!-- Left: tracks nav -->
                    <div class="col-12 col-lg-3 mb-3 mb-lg-0 mt-8">
                        <div class="nav flex-row flex-lg-column nav-pills nav-pills-custom flex-nowrap overflow-auto" id="tracksList" role="tablist">
                            @php
                                $desiredOrder = [13, 7, 8, 9, 10, 11, 12, 14];
                                $orderedTracks = collect($tracks)->sortBy(function($track) use ($desiredOrder) {
                                    $idx = array_search($track->id, $desiredOrder);
                                    return $idx !== false ? $idx : count($desiredOrder); // Non-listed ids go last
                                })->values();
                            @endphp

                            @foreach ($orderedTracks as $t)
                                <button class="list-group-item list-group-item-action"
                                    data-track-id="{{ $t->id }}" type="button">
                                    {{ $t->name }}
                                </button>
                            @endforeach

                            <button class="list-group-item list-group-item-action"
                                data-track-id="next" type="button">
                                NEXT
                            </button>
                        </div>
                    </div>

                    <!-- Right: days and content -->
                    <div class="col-md-9">
                        <!-- MOBILE: track selector (dropdown) and horizontal pills -->
                        {{-- <div class="d-block d-md-none mb-3">
                            <div class="mb-2">
                                <select id="mobileTrackSelect" class="form-select">
                                    <option value="">All tracks</option>
                                    @foreach ($tracks as $t)
                                        <option value="{{ $t->id }}">{{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="mobileTracksPills" class="d-flex gap-2 overflow-auto"
                                style="-webkit-overflow-scrolling:touch;">
                                @foreach ($tracks as $t)
                                    <button class="btn btn-sm btn-outline-secondary mobile-track-btn"
                                        data-track-id="{{ $t->id }}">{{ $t->name }}</button>
                                @endforeach
                            </div>
                        </div> --}}

                        <div class="d-flex justify-content-end">
                            <ul class="nav nav-tabs d-flex flex-nowrap overflow-auto justify-content-lg-end" id="daysTabs" role="tablist">
                                @php $firstDay = true; @endphp
                                @foreach ($days as $num => $date)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link @if ($firstDay) active @endif"
                                            data-day="day{{ $num }}" type="button">Day {{ $num }} :
                                            {{ \Carbon\Carbon::parse($date)->format('d M') }}</button>
                                    </li>
                                    @php $firstDay = false; @endphp
                                @endforeach
                            </ul>
                        </div>

                        @php
                            // Prefer the controller-provided full collection ($allSessions); fall back to the paginated collection if needed
                            if (!isset($allSessions)) {
                                $allSessions =
                                    $sessions instanceof \Illuminate\Pagination\LengthAwarePaginator
                                        ? $sessions->getCollection()
                                        : $sessions;
                            }
                        @endphp

                        <div id="tracksContent" class="col-12 col-lg-9">
                            @foreach ($tracks as $tIdx => $t)
                                @php $isFirstTrack = $tIdx === 0; @endphp
                                <div class="track-pane  @if ($isFirstTrack) active @endif"
                                    data-track-id="{{ $t->id }}">

                                    @foreach ($days as $num => $date)
                                        @php
                                            $dayKey = 'day' . $num;
                                            $sessionsFor = $allSessions->filter(function ($s) use ($t, $dayKey) {
                                                $sDay = isset($s->event_day)
                                                    ? strtolower(str_replace(' ', '', $s->event_day))
                                                    : '';
                                                $sDayNormalized = $sDay ? 'day' . preg_replace('/\D/', '', $sDay) : '';
                                                return (int) ($s->track_id ?? 0) === (int) $t->id &&
                                                    ($sDayNormalized === $dayKey ||
                                                        $sDayNormalized === strtolower($dayKey));
                                            });
                                        @endphp

                                        <div class="day-pane  pink1 mb-1 pb-1 @if ($loop->first) active @endif"
                                            data-day="day{{ $num }}">
                                            <div class="mb-3">
                                                {{-- <h4 class="mb-1 text-primary">{{ $t->name }} - Day {{ $num }}</h4> --}}
                                                <h4 class="mb-1 text-primary mb-1 pb-1">{{ strtoupper($t->name) }} </h4>
                                                {{-- <p class="text-muted"> Day {{ $num }} Content</p> --}}
                                            </div>

                                            @if ($sessionsFor->isEmpty())
                                                <div class="alert alert-light">No sessions for this track and day.</div>
                                            @else
                                                <div class="row g-3 session-list ">
                                                    @foreach ($sessionsFor as $session)
                                                        <div class="col-12 session-card ">
                                                            <div class="">
                                                                <div
                                                                    class="agenda-item d-flex flex-column flex-md-row justify-content-between">
                                                                    <div class="flex-grow-1">
                                                                        <div class="d-flex align-items-center gap-2 mb-2">
                                                                            {{-- @if (optional($session->event)->name)
                                                                                <span class="badge bg-light text-dark">{{ optional($session->event)->name }}</span>
                                                                            @endif --}}
                                                                            {{-- @if ($session->event_day)
                                                                                <span class="badge bg-primary text-white">{{ ucfirst($session->event_day) }}</span>
                                                                            @endif --}}
                                                                            {{-- @if ($session->format)
                                                                                <span class="badge bg-success">{{ $session->format }}</span>
                                                                            @endif
                                                                            @if ($session->level)
                                                                                <span class="badge bg-warning text-dark">{{ $session->level }}</span>
                                                                            @endif --}}
                                                                        </div>

                                                                        <h5 class="card-title mb-1 pink1">
                                                                            {{ $session->title }}</h5>
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
                                                                                <div class="meta-item time mt-2"><svg
                                                                                        class="meta-icon"
                                                                                        fill="currentColor"
                                                                                        viewBox="0 0 20 20">
                                                                                        <path fill-rule="evenodd"
                                                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                                            clip-rule="evenodd"></path>
                                                                                    </svg>
                                                                                    {{ $session->starts_at ? $session->starts_at->format('M d, H:i') : '' }}
                                                                                    -
                                                                                    {{ $session->ends_at ? $session->ends_at->format('H:i') : '' }}
                                                                                </div>
                                                                                <div class="meta-item venue mt-2"><svg
                                                                                        class="meta-icon"
                                                                                        fill="currentColor"
                                                                                        viewBox="0 0 20 20">
                                                                                        <path fill-rule="evenodd"
                                                                                            d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                                                            clip-rule="evenodd"></path>
                                                                                    </svg>
                                                                                    {{ $session->location ?? '—' }}</div>
                                                                            </div>
                                                                            <p class="mb-2 session-description">{{ $session->description }}
                                                                            </p>

                                                                            <div class="mt-2">
                                                                                {{-- <strong>Speakers</strong> --}}
                                                                                <div class="row g-4 pg-spk">
                                                                                    @foreach ($session->speakers as $speaker)
                                                                                        @php
                                                                                            $parts = preg_split(
                                                                                                '/\\s+/',
                                                                                                trim($speaker->name),
                                                                                            );
                                                                                            $initials = strtoupper(
                                                                                                substr(
                                                                                                    $parts[0] ?? '',
                                                                                                    0,
                                                                                                    1,
                                                                                                ) .
                                                                                                    (isset($parts[1])
                                                                                                        ? substr(
                                                                                                            $parts[1],
                                                                                                            0,
                                                                                                            1,
                                                                                                        )
                                                                                                        : ''),
                                                                                            );
                                                                                        @endphp
                                                                                        <div
                                                                                            class="col-12 col-md-6 col-lg-3 text-center">
                                                                                            <div class="profile-card">
                                                                                                <div
                                                                                                    class="circular-image-container mb-3">
                                                                                                    @if (!empty($speaker->image_path))
                                                                                                        <img src="{{ $speaker->image_path }}"
                                                                                                            alt="{{ $speaker->name }}"
                                                                                                            class="img-fluid circular-image">
                                                                                                    @else
                                                                                                        <div
                                                                                                            class="circular-placeholder">
                                                                                                            <span
                                                                                                                class="placeholder-text">{{ $initials }}</span>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>
                                                                                                <h5 class="name">
                                                                                                    {{ $speaker->name }}
                                                                                                </h5>
                                                                                                @if ($speaker->title)
                                                                                                    <p class="title">
                                                                                                        {{ $speaker->title }}
                                                                                                        <br>
                                                                                                        @if ($speaker->company)
                                                                                                   
                                                                                                        {{ $speaker->company }}
                                                                                                        @endif
                                                                                                   
                                                                                                @endif
                                                                                                    </p>
                                                                                                
                                                                                                
                                                                                                {{-- Optionally, add a profile button if there's a URL --}}
                                                                                                @if (!empty($speaker->linkedin))
                                                                                                    <p>
                                                                                                        <a href="{{ $speaker->linkedin }}"
                                                                                                            target="_blank"
                                                                                                            class="btn gradient-btn2 rounded-pill py-1 px-4 ms-0 mt-0 mb-2">
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

                        <div class="mt-3 d-flex justify-content-center">{{ $sessions->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Slight visual tweaks to match requested design */
        /* Left track cards */
        #tracksList {
            padding: 8px;
        }

        #tracksList .list-group-item {
            border-radius: 10px;
            background: #ffffff;
            border: 1px solid #eef1f5;
            padding: 18px 14px;
            font-weight: 700;
            color: #c81980;
            box-shadow: 0 1px 2px rgba(16, 24, 40, 0.03);
        }

        #tracksList .list-group-item+.list-group-item {
            margin-top: 12px;
        }

        /* Active track style - gradient pill */
        #tracksList .list-group-item.active {
            background: linear-gradient(90deg, #2C3A8C 0%, #F72C70 100%);
            color: #fff;
            box-shadow: 0 6px 18px rgba(39, 24, 83, 0.15);
            border: none;
            transform: translateY(-2px);
        }

        /* Right content background to match sample (light gray area) */
        .card-body {
            background: #f4f6f8;
            border-radius: 8px;
        }

        /* Inner white panel for the active day content */
        .day-pane {
            padding: 18px;
        }

        .day-pane>.mb-3 {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(16, 24, 40, 0.04);
        }

        /* Session card visual */
        .session-card .card {
            border: 1px solid #edf2f7;
            border-radius: 8px;
        }

        .session-card .card-body {
            background: #fff;
        }

        /* Pill style day tabs on the right */
        #daysTabs {
            gap: 8px;
        }

        #daysTabs .nav-link {
            border-radius: 20px;
            background: linear-gradient(90deg, #5f3a8c, #c81980);
            color: #fff;
            padding: 8px 16px;
            margin-left: 6px;
            box-shadow: 0 4px 12px rgba(39, 24, 83, 0.12);
        }

        #daysTabs .nav-link:not(.active) {
            opacity: 0.85;
            background: #6b2f7a;
        }

        /* Mobile-specific track pills */
        .mobile-track-btn {
            white-space: nowrap;
            flex: 0 0 auto;
            border-radius: 18px;
        }

        .mobile-track-btn.active {
            background: linear-gradient(90deg, #2C3A8C, #F72C70);
            color: #fff;
            border-color: transparent;
        }

        /* make left column scrollable if many tracks */
        @media(min-width: 768px) {
            #tracksList {
                max-height: 80vh;
                overflow: auto;
                padding-right: 6px;
            }
        }

        /* Pane visibility controlled with classes for predictable JS */
        .track-pane {
            display: none;
        }

        .track-pane.active {
            display: block;
        }

        .day-pane {
            display: none;
        }

        .day-pane.active {
            display: block;
        }

        /* Mobile day panes (accordion per day) */
        .mobile-day-pane {
            display: none;
        }

        .mobile-day-pane.active {
            display: block;
        }

        /* small screens tweaks */
        @media(max-width: 767.98px) {
            #tracksList {
                display: flex;
                gap: 10px;
                overflow: auto;
            }

            #tracksList .list-group-item {
                min-width: 160px;
                flex: 0 0 auto;
            }

            #daysTabs {
                justify-content: flex-start;
            }
        }
    </style>

    <script>
        (function() {
            const tracksList = document.getElementById('tracksList');
            const mobileTrackSelect = document.getElementById('mobileTrackSelect');
            const mobileTrackBtns = Array.from(document.querySelectorAll('.mobile-track-btn'));
            const dayButtons = Array.from(document.querySelectorAll('#daysTabs .nav-link'));
            const tracksContent = document.getElementById('tracksContent');
            const search = document.getElementById('live-search');
            const formatFilter = document.getElementById('format-filter');

            // Initial active selections
            let activeTrackId = tracksList.querySelector('[data-track-id]') ? tracksList.querySelector(
                '[data-track-id]').getAttribute('data-track-id') : null;
            let activeDay = dayButtons.length ? dayButtons[0].getAttribute('data-day') : null;

            // Helper: find active track pane
            function getActiveTrackPane() {
                return tracksContent.querySelector('.track-pane.active');
            }

            // Activate a given track id (by toggling active classes)
            function activateTrack(trackId) {
                // buttons (desktop)
                Array.from(tracksList.querySelectorAll('[data-track-id]')).forEach(b => b.classList.toggle('active', b
                    .getAttribute('data-track-id') === String(trackId)));
                // mobile select
                if (mobileTrackSelect) mobileTrackSelect.value = trackId || '';
                // mobile pills
                mobileTrackBtns.forEach(b => b.classList.toggle('active', b.getAttribute('data-track-id') === String(
                    trackId)));
                // panes
                Array.from(tracksContent.querySelectorAll('.track-pane')).forEach(p => p.classList.toggle('active', p
                    .getAttribute('data-track-id') === String(trackId)));

                // ensure the active day pane is visible inside the active track
                const pane = getActiveTrackPane();
                if (pane) {
                    const dayPaneToShow = pane.querySelector('.day-pane[data-day="' + activeDay + '"]') || pane
                        .querySelector('.day-pane');
                    pane.querySelectorAll('.day-pane').forEach(dp => dp.classList.remove('active'));
                    if (dayPaneToShow) dayPaneToShow.classList.add('active');
                }
            }

            // Activate a given day globally
            function activateDay(dayKey) {
                activeDay = dayKey;
                dayButtons.forEach(b => b.classList.toggle('active', b.getAttribute('data-day') === dayKey));
                const pane = getActiveTrackPane();
                if (pane) {
                    pane.querySelectorAll('.day-pane').forEach(dp => dp.classList.toggle('active', dp.getAttribute(
                        'data-day') === dayKey));
                }
                // also toggle mobile-day-pane visibility
                Array.from(document.querySelectorAll('.mobile-day-pane')).forEach(md => md.classList.toggle('active', md
                    .getAttribute('data-day') === dayKey));
            }

            // Setup desktop track buttons
            Array.from(tracksList.querySelectorAll('[data-track-id]')).forEach(btn => {
                btn.addEventListener('click', function() {
                    activeTrackId = this.getAttribute('data-track-id');
                    activateTrack(activeTrackId);
                    filterVisibleSessions();
                });
            });

            // Setup mobile track select (dropdown)
            if (mobileTrackSelect) {
                mobileTrackSelect.addEventListener('change', function() {
                    const val = this.value || null;
                    activeTrackId = val;
                    activateTrack(activeTrackId);
                    updateMobileAccordions();
                    filterVisibleSessions();
                });
            }

            // Setup mobile track pills
            mobileTrackBtns.forEach(btn => btn.addEventListener('click', function() {
                const id = this.getAttribute('data-track-id');
                activeTrackId = id;
                activateTrack(activeTrackId);
                updateMobileAccordions();
                filterVisibleSessions();
            }));

            // Show/hide mobile accordion items when a specific track is selected on mobile
            function updateMobileAccordions() {
                // if no mobile elements, skip
                const mobilePanes = Array.from(document.querySelectorAll('.mobile-day-pane'));
                if (!mobilePanes.length) return;

                mobilePanes.forEach(pane => {
                    const items = Array.from(pane.querySelectorAll('.accordion-item'));
                    items.forEach(item => {
                        const tid = item.getAttribute('data-track-id');
                        if (!activeTrackId || String(activeTrackId) === '') {
                            item.style.display = ''; // show all
                        } else {
                            item.style.display = (String(tid) === String(activeTrackId)) ? '' : 'none';
                            // if hiding, ensure collapse inside is closed
                            if (String(tid) !== String(activeTrackId)) {
                                const collapse = item.querySelector('.accordion-collapse');
                                if (collapse && collapse.classList.contains('show')) {
                                    // using bootstrap's collapse if available
                                    try {
                                        var bs = bootstrap.Collapse.getInstance(collapse);
                                        if (bs) bs.hide();
                                    } catch (e) {}
                                }
                            }
                        }
                    });
                });

                // toggle between accordion view and single-track list on mobile
                const mobileTrackList = document.getElementById('mobileTrackList');
                if (!mobileTrackList) return;
                if (!activeTrackId || String(activeTrackId) === '') {
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
            function renderMobileTrackList() {
                const mobileTrackList = document.getElementById('mobileTrackList');
                if (!mobileTrackList) return;
                const pane = getActiveTrackPane();
                if (!pane) {
                    mobileTrackList.innerHTML = '<div class="text-muted">No sessions</div>';
                    return;
                }
                const visibleDayPane = pane.querySelector('.day-pane.active');
                if (!visibleDayPane) {
                    mobileTrackList.innerHTML = '<div class="text-muted">No sessions for this day</div>';
                    return;
                }
                // clone the inner content of visibleDayPane's session-list (or entire day pane)
                const list = visibleDayPane.querySelector('.session-list');
                if (list) {
                    mobileTrackList.innerHTML = list.outerHTML;
                } else {
                    mobileTrackList.innerHTML = visibleDayPane.innerHTML;
                }
            }

            // Mark first track active on load
            const firstTrackBtn = tracksList.querySelector('[data-track-id]');
            if (firstTrackBtn) {
                activeTrackId = firstTrackBtn.getAttribute('data-track-id');
                activateTrack(activeTrackId);
            }

            // ensure mobile accordions reflect the initial active track
            updateMobileAccordions();
            // also render initial mobile single-track list if applicable
            renderMobileTrackList();

            // Day tabs listeners
            dayButtons.forEach(btn => btn.addEventListener('click', function() {
                activateDay(this.getAttribute('data-day'));
                filterVisibleSessions();
            }));

            // Search debounce
            let debounce;
            if (search) {
                search.addEventListener('input', function() {
                    clearTimeout(debounce);
                    debounce = setTimeout(filterVisibleSessions, 300);
                });
            }

            if (formatFilter) {
                formatFilter.addEventListener('change', filterVisibleSessions);
            }

            function filterVisibleSessions() {
                const pane = getActiveTrackPane();
                if (!pane) return;
                const visibleDayPane = pane.querySelector('.day-pane.active');
                if (!visibleDayPane) return;

                const q = (search && search.value) ? search.value.trim().toLowerCase() : '';
                const formatVal = (formatFilter && formatFilter.value) ? formatFilter.value.toLowerCase() : '';

                Array.from(visibleDayPane.querySelectorAll('.session-card')).forEach(cardWrap => {
                    const card = cardWrap.querySelector('.card');
                    if (!card) return;
                    const text = card.textContent.toLowerCase();
                    const matchesQ = !q || text.includes(q);
                    const matchesFormat = !formatVal || text.includes(formatVal);
                    cardWrap.style.display = (matchesQ && matchesFormat) ? '' : 'none';
                });
            }

            // Apply initial day selection (first day)
            if (dayButtons.length) activateDay(dayButtons[0].getAttribute('data-day'));

            // initial filter
            filterVisibleSessions();
        })();
    </script>
@endsection
