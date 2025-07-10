@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">{{ $trip->title }}</h1>
        <p class="text-gray-600 mb-2">{{ $trip->description }}</p>
        <p class="text-sm text-gray-500 mb-1">{{ __('messages.trip_date') }}: {{ $trip->trip_date }}</p>
        <p class="text-sm text-gray-500 mb-2">{{ __('messages.added_by') }}: {{ $trip->user->name ?? __('messages.unknown') }}</p>
        @if($trip->photos && $trip->photos->count())
            <div class="my-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($trip->photos as $photo)
                    <div class="bg-gray-50 rounded-lg shadow p-2 flex flex-col items-center" x-data="{ showModal: false }">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Photo" class="w-full rounded mb-2 max-h-64 object-cover cursor-pointer" @click="showModal = true">
                        @if($photo->caption)
                            <div class="text-sm text-gray-700 text-center">{{ $photo->caption }}</div>
                        @endif
                        <!-- Modal -->
                        <div x-show="showModal" style="display: none" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70">
                            <div class="relative bg-white rounded-lg shadow-lg p-4 max-w-3xl w-full flex flex-col items-center">
                                <button @click="showModal = false" class="absolute top-2 right-2 text-2xl text-gray-600 hover:text-red-600">&times;</button>
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Photo" class="max-h-[80vh] max-w-full rounded" />
                                @if($photo->caption)
                                    <p class="text-center text-gray-500 text-sm mt-2">{{ $photo->caption }}</p>
                                @endif
                            </div>
                            <div @click="showModal = false" class="absolute inset-0"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="flex gap-2 mb-4">
                <a href="{{ route('trips.edit', $trip->id) }}" class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition">{{ __('messages.edit') }}</a>
                <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition">{{ __('messages.delete') }}</button>
                </form>
            </div>
        @endif
        <div class="mb-6">
            <span 
                x-data="{ open: false }" 
                @mouseenter="open = true" 
                @mouseleave="open = false" 
                class="relative inline-block bg-pink-100 text-pink-700 px-3 py-1 rounded-full text-sm font-semibold cursor-pointer"
            >
                {{ __('messages.total_likes') }}: {{ $likesCount }}
                @if($likesCount > 0)
                    <div 
                        x-show="open" 
                        x-transition 
                        class="absolute left-1/2 z-10 bg-white text-gray-800 border border-gray-300 rounded shadow-lg px-4 py-2 text-xs min-w-[120px] -translate-x-1/2 mt-2 whitespace-nowrap"
                        style="min-width:150px;"
                    >
                        <div class="font-bold mb-1">{{ __('messages.total_likes') }}</div>
                        @foreach($trip->likes as $like)
                            <div>{{ $like->user->name ?? __('messages.unknown') }}</div>
                        @endforeach
                    </div>
                @endif
            </span>
            @auth
                @php
                    $userLiked = $trip->likes->where('user_id', auth()->id())->count() > 0;
                @endphp
                <form action="{{ $userLiked ? route('likes.destroy', $trip->id) : route('likes.store', $trip->id) }}" method="POST" class="inline-block ml-4">
                    @csrf
                    @if($userLiked)
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition">{{ __('messages.unlike') }}</button>
                    @else
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded shadow hover:bg-red-700 transition">{{ __('messages.like') }}</button>
                    @endif
                </form>
            @endauth
        </div>
        <hr class="my-6">
        <h2 class="text-lg font-bold mb-2">{{ __('messages.comments') }}</h2>
        @if($comments->isEmpty())
            <p>{{ __('messages.no_comments') }}</p>
        @else
            <div class="space-y-4 mb-6">
                @foreach($comments as $comment)
                    <div class="border rounded p-3 bg-gray-50 flex justify-between items-center">
                        <div>
                            <span class="font-semibold">{{ $comment->user->name }}</span>
                            <span class="text-xs text-gray-500 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                            <p class="mt-1">{{ $comment->comment }}</p>
                        </div>
                        @if(auth()->check() && auth()->user()->role === 'admin')
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete_comment') }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-xs">{{ __('messages.delete') }}</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
        @auth
            <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
                @csrf
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                <div class="mb-2">
                    <textarea name="comment" rows="3" class="w-full border rounded px-3 py-2" placeholder="{{ __('messages.add_comment') }}..." required>{{ old('comment') }}</textarea>
                    @error('comment')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
                </div>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">{{ __('messages.add_comment') }}</button>
            </form>
        @else
            <p class="text-gray-600">{{ __('messages.login_to_comment') }} <a href="{{ route('login') }}" class="text-blue-600 hover:underline">{{ __('Login') }}</a>.</p>
        @endauth
        <a href="{{ route('trips.index') }}" class="text-blue-600 hover:underline">&larr; {{ __('messages.album_title') }}</a>
    </div>
</div>
@endsection 