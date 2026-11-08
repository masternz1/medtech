<x-app-layout>
    <x-slot name="header">Profile settings</x-slot>

    <div class="space-y-12 divide-y divide-slate-200 [&>section]:pt-12 [&>section:first-child]:pt-0">
        @include('profile.partials.update-profile-information-form')
        @include('profile.partials.update-password-form')
        @include('profile.partials.delete-user-form')
    </div>
</x-app-layout>
