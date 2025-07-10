<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Trip;

class LikeController extends Controller
{
    // Beğeni ekle
    public function store(Trip $trip)
    {
        $user = auth()->user();
        // Kullanıcı daha önce beğenmiş mi?
        $alreadyLiked = Like::where('user_id', $user->id)->where('trip_id', $trip->id)->exists();
        if (!$alreadyLiked) {
            Like::create([
                'user_id' => $user->id,
                'trip_id' => $trip->id,
            ]);
        }
        return redirect()->back();
    }

    // Beğeni kaldır
    public function destroy(Trip $trip)
    {
        $user = auth()->user();
        Like::where('user_id', $user->id)->where('trip_id', $trip->id)->delete();
        return redirect()->back();
    }
}
