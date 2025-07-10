@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start bg-gray-100 py-8">
    <div class="w-full max-w-2xl mx-auto">
        <div class="flex flex-col items-center mb-8">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ __('Gezi Albümü') }}</h1>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('trips.create') }}" class="bg-red-600 text-white px-5 py-2 rounded-lg shadow-lg hover:bg-red-700 transition font-bold text-base mb-2 flex items-center gap-2">
                    <span class="text-xl">＋</span> {{ __('Yeni Gezi Ekle') }}
                </a>
            @endif
        </div>
        <ul class="bg-white rounded-lg shadow divide-y divide-gray-200">
            @forelse($trips as $trip)
                <li>
                    <a href="{{ route('trips.show', $trip) }}" class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition">
                        <div>
                            <div class="font-semibold text-lg text-[#0066cc]">{{ $trip->title }}</div>
                            <div class="text-gray-700 text-sm mt-1">{{ $trip->description }}</div>
                        </div>
                        <div class="text-gray-500 text-sm whitespace-nowrap ml-4">{{ $trip->trip_date }}</div>
                    </a>
                </li>
            @empty
                <li class="px-6 py-4 text-gray-500">Hiç gezi eklenmemiş.</li>
            @endforelse
        </ul>
    </div>
</div>
<footer class="text-center mt-12 mb-4 text-gray-500">
    <p>&copy; 2025 Berke Ermiş - My Memories</p>
</footer>
@endsection
