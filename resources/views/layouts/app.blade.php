@extends('layouts.public')

@section('title', config('app.name', 'MedTech Distributions'))

@section('content')
    <div class="page-head">
        <div class="shell py-12 sm:py-16">
            @isset($header)
                <h1>{{ $header }}</h1>
            @else
                <h1>Your account</h1>
            @endisset
        </div>
    </div>

    <div class="shell py-6">
        @include('customer._nav')
        <div class="max-w-2xl py-8">
            {{ $slot }}
        </div>
    </div>
@endsection
