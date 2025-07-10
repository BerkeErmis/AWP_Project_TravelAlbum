@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-start bg-gray-100 py-8">
    <div class="w-full mx-auto">
        <div class="flex flex-col items-center mb-8">
            <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ __('messages.album_title') }}</h1>
            @if(auth()->check() && auth()->user()->role === 'admin')
                <a href="{{ route('trips.create') }}" class="bg-red-600 text-white px-5 py-2 rounded-lg shadow-lg hover:bg-red-700 transition font-bold text-base mb-2 flex items-center gap-2">
                    <span class="text-xl">＋</span> {{ __('messages.add_trip') }}
                </a>
            @endif
        </div>
        @if($trips->isEmpty())
            <div class="bg-white rounded shadow p-8 flex flex-col items-center justify-center mt-12">
                <p class="text-gray-500 text-lg">{{ __('messages.no_trips') }}</p>
            </div>
        @else
            <section class="gallery flex flex-wrap justify-center gap-8 mt-8">
                @foreach($trips as $trip)
                    <div class="city-card w-[300px] bg-white border border-gray-300 rounded-[10px] overflow-hidden shadow-md flex flex-col mb-8">
                        <div class="slider group relative w-full pt-[75%] overflow-hidden" x-data="{ photos: @json($trip->photos), active: 0 }">
                            @if($trip->photos && $trip->photos->count() > 0)
                                <template x-for="(photo, idx) in photos" :key="idx">
                                    <div x-show="active === idx" class="slide absolute top-0 left-0 w-full h-full opacity-0 translate-x-full transition-all duration-500" :class="{ 'active opacity-100 translate-x-0': active === idx, 'previous -translate-x-full': active !== idx }">
                                        <img :src="'/storage/' + photo.photo_path" :alt="photo.caption ? photo.caption : '{{ $trip->title }}'" class="w-full h-full object-cover object-center" />
                                        <p class="absolute bottom-0 left-0 right-0 m-0 p-2 bg-black bg-opacity-60 text-white text-[0.9em]" x-text="photo.caption"></p>
                                    </div>
                                </template>
                                <template x-if="photos.length > 1">
                                    <>
                                        <button @click.stop="active = (active - 1 + photos.length) % photos.length" type="button" class="nav-button nav-prev absolute left-[10px] top-1/2 -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white border-none px-[10px] py-[15px] cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 text-[18px] rounded">❮</button>
                                        <button @click.stop="active = (active + 1) % photos.length" type="button" class="nav-button nav-next absolute right-[10px] top-1/2 -translate-y-1/2 bg-black bg-opacity-30 hover:bg-opacity-50 text-white border-none px-[10px] py-[15px] cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 text-[18px] rounded">❯</button>
                                        <div class="slider-dots flex justify-center gap-[6px] absolute bottom-2 left-1/2 -translate-x-1/2 z-10">
                                            <template x-for="(photo, idx) in photos" :key="'dot'+idx">
                                                <div @click="active = idx" :class="{'bg-[#0066cc]': active === idx, 'bg-gray-300': active !== idx }" class="dot w-[6px] h-[6px] rounded-full cursor-pointer transition-colors duration-300"></div>
                                            </template>
                                        </div>
                                    </>
                                </template>
                            @else
                                <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center text-gray-400 text-6xl bg-gray-200">
                                    <span>📷</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-[1.17em] font-bold text-[#0066cc] text-center mt-[10px] mb-[10px]">{{ $trip->title }}</h3>
                        <p class="text-gray-700 text-center mb-[10px] mx-[10px]">{{ $trip->description }}</p>
                    </div>
                @endforeach
            </section>
        @endif
    </div>
</div>
@endsection 