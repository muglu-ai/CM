<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Speakers by Track</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <h1 class="h4 mb-4">Speakers by Track</h1>

    @if($tracks->isEmpty())
        <div class="alert alert-info">No tracks with speakers found.</div>
    @endif

    @foreach($tracks as $track)
        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h5 mb-0">{{ $track->name }}</h2>
                <small class="text-muted">{{ $track->speakers->count() }} speaker{{ $track->speakers->count() === 1 ? '' : 's' }}</small>
            </div>

            <div class="row g-3">
                @foreach($track->speakers as $speaker)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                        <div class="card h-100">
                            <div class="d-flex p-3 align-items-start">
                                <img src="{{ $speaker->image_url }}" alt="{{ $speaker->name }}" class="rounded me-3" style="width:80px;height:80px;object-fit:cover;">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1">{{ $speaker->name }}</h5>
                                    @if($speaker->title || $speaker->company)
                                        <div class="text-muted small">{{ trim(($speaker->title ? $speaker->title . ' @ ' : '') . ($speaker->company ?? '')) }}</div>
                                    @endif
                                    @if($speaker->bio)
                                        <p class="card-text small text-muted mt-2 mb-0">{{ \Illuminate\Support\Str::limit($speaker->bio, 120) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
