@php
    $candidates = [
        'images/dorsu-logo.png',
        'images/dorsu-logo.PNG',
        'images/dorsu-logo.webp',
        'images/dorsu-logo.jpg',
        'images/dorsu-logo.jpeg',
        'dorsu-logo.png',
        'dorsu-logo.webp',
        'dorsu-logo.jpg',
        'logo.png',
        'logo.jpg',
    ];
    $logoPath = null;
    foreach ($candidates as $candidate) {
        if (file_exists(public_path($candidate))) {
            $logoPath = $candidate;
            break;
        }
    }

    // If no known filename found, try any image in public/images
    if (!$logoPath && is_dir(public_path('images'))) {
        $any = glob(public_path('images/*.{png,PNG,webp,jpg,jpeg,JPG,JPEG,gif}'), GLOB_BRACE);
        if (!empty($any)) {
            $logoPath = 'images/'.basename($any[0]);
        }
    }

    // Also support storage path if linked (storage:link)
    if (!$logoPath) {
        $storageCandidates = [
            'logo.png','logo.jpg','logo.webp','dorsu-logo.png','dorsu-logo.jpg','dorsu-logo.webp'
        ];
        foreach ($storageCandidates as $sc) {
            if (file_exists(public_path('storage/'.$sc))) {
                $logoPath = 'storage/'.$sc;
                break;
            }
        }
    }
@endphp

@if ($logoPath)
    <img src="{{ asset($logoPath) }}" alt="Baganga campus" {{ $attributes->merge(['class' => 'w-8 h-7 mx-auto object-contain']) }} />
@else
    <div {{ $attributes->merge(['class' => 'w-8 h-7 mx-auto flex items-center justify-center bg-gray-20 text-gray-60 rounded-full']) }}>Logo</div>
@endif
