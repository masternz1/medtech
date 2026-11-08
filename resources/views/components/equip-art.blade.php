@props(['name' => '', 'slug' => ''])
@php
    // Picks the equipment drawing that best matches a category or product, from its name or slug.
    $hay = strtolower(trim($slug . ' ' . $name));
    $file = 'other-medical-equipment';
    $rules = [
        'ultrasound-systems'  => '/ultrasound|sonograph|doppler/',
        'ct-scanners'         => '/\bct\b|ct[- ]scan|tomograph/',
        'x-ray-machines'      => '/x[- ]?ray|radiograph|fluoroscop/',
        'mri-machines'        => '/\bmri\b|magnetic resonance/',
        'mammography'         => '/mammo/',
        'dialysis-machines'   => '/dialy/',
        'ventilators'         => '/ventilat|bipap|cpap|respirat|oxygen/',
        'vital-sign-monitors' => '/monitor|vital|ecg|ekg|pulse|spo2/',
        'analyzers'           => '/analy[sz]er|laborator|haemat|hemat|biochem/',
    ];
    foreach ($rules as $candidate => $pattern) {
        if (preg_match($pattern, $hay)) { $file = $candidate; break; }
    }
@endphp
<img src="{{ asset('images/equipment/' . $file . '.svg') }}" alt="" width="480" height="360" loading="lazy" {{ $attributes->merge(['class' => 'max-h-full max-w-full object-contain']) }}>
