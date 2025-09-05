<x-admin-layout>
    <x-slot name="header">
        Profil Admin
    </x-slot>

    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white rounded-lg shadow-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white rounded-lg shadow-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</x-admin-layout>
