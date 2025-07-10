@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Geziyi Düzenle</h1>
        <form action="{{ route('trips.update', $trip->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block font-semibold mb-1" for="title">Şehir Adı</label>
                <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" required value="{{ old('title', $trip->title) }}">
                @error('title')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1" for="description">Açıklama</label>
                <textarea name="description" id="description" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('description', $trip->description) }}</textarea>
                @error('description')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1" for="trip_date">Gezi Tarihi</label>
                <input type="date" name="trip_date" id="trip_date" class="w-full border rounded px-3 py-2" required value="{{ old('trip_date', $trip->trip_date) }}">
                @error('trip_date')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-6">
                <label class="block font-semibold mb-1" for="photo_path">Fotoğraf</label>
                @if($trip->photo_path)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $trip->photo_path) }}" alt="{{ $trip->title }}" class="w-32 rounded">
                    </div>
                @endif
                <input type="file" name="photo_path" id="photo_path" class="w-full">
                <small class="text-gray-500">(Yeni fotoğraf seçerseniz eskisi silinmez, üzerine yazılır.)</small>
                @error('photo_path')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">Güncelle</button>
            <a href="{{ route('trips.show', $trip->id) }}" class="ml-4 text-gray-600 hover:underline">İptal</a>
        </form>
    </div>
</div>
@endsection 