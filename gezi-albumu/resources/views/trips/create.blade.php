@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">{{ __('messages.add_trip') }}</h1>
        <form action="{{ route('trips.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block font-semibold mb-1" for="title">{{ __('messages.city_name') ?? 'Şehir Adı' }}</label>
                <input type="text" name="title" id="title" class="w-full border rounded px-3 py-2" required value="{{ old('title') }}">
                @error('title')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1" for="description">{{ __('messages.description') ?? 'Açıklama' }}</label>
                <textarea name="description" id="description" class="w-full border rounded px-3 py-2" rows="4" required>{{ old('description') }}</textarea>
                @error('description')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-4">
                <label class="block font-semibold mb-1" for="trip_date">{{ __('messages.trip_date') }}</label>
                <input type="date" name="trip_date" id="trip_date" class="w-full border rounded px-3 py-2" required value="{{ old('trip_date') }}">
                @error('trip_date')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <div class="mb-6">
                <label class="block font-semibold mb-1">{{ __('messages.photo') ?? 'Fotoğraf' }}</label>
                <div id="photos-wrapper">
                    <div class="flex items-center gap-2 mb-2 photo-row">
                        <input type="file" name="photos[]" class="w-1/2" required>
                        <input type="text" name="captions[]" class="w-1/2 border rounded px-3 py-2" placeholder="{{ __('messages.description') ?? 'Açıklama' }}">
                        <button type="button" onclick="removePhotoRow(this)" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">{{ __('messages.delete') ?? 'Sil' }}</button>
                    </div>
                </div>
                <button type="button" onclick="addPhotoRow()" class="mt-2 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">+ {{ __('messages.add_photo') ?? 'Fotoğraf Ekle' }}</button>
                <script>
                    function addPhotoRow() {
                        const wrapper = document.getElementById('photos-wrapper');
                        const row = document.createElement('div');
                        row.className = 'flex items-center gap-2 mb-2 photo-row';
                        row.innerHTML = `
                            <input type="file" name="photos[]" class="w-1/2" required>
                            <input type="text" name="captions[]" class="w-1/2 border rounded px-3 py-2" placeholder="{{ __('messages.description') ?? 'Açıklama' }}">
                            <button type="button" onclick="removePhotoRow(this)" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 transition">{{ __('messages.delete') ?? 'Sil' }}</button>
                        `;
                        wrapper.appendChild(row);
                    }
                    function removePhotoRow(btn) {
                        btn.parentElement.remove();
                    }
                </script>
                @error('photos')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition">{{ __('messages.save') }}</button>
            <a href="{{ route('trips.index') }}" class="ml-4 bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700 transition inline-block text-center">{{ __('messages.cancel') }}</a>
        </form>
    </div>
</div>
@endsection 