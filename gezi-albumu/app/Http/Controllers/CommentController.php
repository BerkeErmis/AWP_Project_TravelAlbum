<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    // Yorum ekleme
    public function store(Request $request)
    {
        $validated = $request->validate([
            'trip_id' => 'required|exists:trips,id',
            'comment' => 'required|string|max:1000',
        ]);
        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->trip_id = $validated['trip_id'];
        $comment->comment = $validated['comment'];
        $comment->save();
        return redirect()->back()->with('success', 'Yorumunuz eklendi!');
    }

    // Yorum silme (sadece admin)
    public function destroy(Comment $comment)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin') {
            abort(403, 'Bu işlemi yapmaya yetkiniz yok.');
        }
        $comment->delete();
        return redirect()->back()->with('success', 'Yorum silindi!');
    }
}
