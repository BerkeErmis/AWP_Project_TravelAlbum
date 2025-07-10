@extends('layouts.app')
@section('content')
<div class="min-h-screen flex flex-col items-center justify-start bg-gray-100 py-8">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">{{ __('Profile') }}</h1>
            <div class="space-y-8">
                <div class="bg-gray-50 rounded-xl shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">{{ __('Profile Information') }}</h2>
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="bg-gray-50 rounded-xl shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">{{ __('Update Password') }}</h2>
                    @include('profile.partials.update-password-form')
                </div>
                <div class="bg-gray-50 rounded-xl shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 text-gray-700">{{ __('Delete Account') }}</h2>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
