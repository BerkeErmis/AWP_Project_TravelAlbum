<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trips = \App\Models\Trip::with(['user', 'photos'])->orderBy('trip_date', 'desc')->get();
        return view('trips.index', compact('trips'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }
        return view('trips.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'trip_date' => 'required|date',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $trip = new \App\Models\Trip();
        $trip->title = $validated['title'];
        $trip->description = $validated['description'];
        $trip->trip_date = $validated['trip_date'];
        $trip->user_id = auth()->id();
        $trip->save();

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $idx => $photoFile) {
                $photoPath = $photoFile->store('trips', 'public');
                $caption = $request->input('captions')[$idx] ?? null;
                $trip->photos()->create([
                    'photo_path' => $photoPath,
                    'caption' => $caption,
                ]);
            }
        }

        return redirect()->route('trips.index')->with('success', 'Gezi başarıyla eklendi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $trip = \App\Models\Trip::with(['user'])->findOrFail($id);
        $comments = $trip->comments()->with('user')->orderBy('created_at', 'desc')->get();
        $likesCount = $trip->likes()->count();
        return view('trips.show', compact('trip', 'comments', 'likesCount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }
        $trip = \App\Models\Trip::findOrFail($id);
        return view('trips.edit', compact('trip'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }
        $trip = \App\Models\Trip::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'trip_date' => 'required|date',
            'photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);
        if ($request->hasFile('photo_path')) {
            $photoPath = $request->file('photo_path')->store('trips', 'public');
            $trip->photo_path = $photoPath;
        }
        $trip->title = $validated['title'];
        $trip->description = $validated['description'];
        $trip->trip_date = $validated['trip_date'];
        $trip->save();
        return redirect()->route('trips.show', $trip->id)->with('success', 'Gezi başarıyla güncellendi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }
        $trip = \App\Models\Trip::findOrFail($id);
        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Gezi başarıyla silindi!');
    }
}
