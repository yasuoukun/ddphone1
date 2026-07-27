<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'is_anonymous' => 'nullable|boolean',
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,webp,mp4,mov|max:51200',
        ]);

        $mediaPaths = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $mediaPaths[] = $file->store('reviews', 'public');
            }
        }

        Review::create([
            'user_id' => auth()->id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'media_paths' => $mediaPaths,
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        return redirect()->back()->with('sweet_success', 'ส่งรีวิวพร้อมรูปภาพ/วิดีโอเรียบร้อยแล้ว ขอบคุณสำหรับคำแนะนำครับ!');
    }

    public function toggleLike(Review $review)
    {
        $sessionKey = 'liked_review_' . $review->id;
        $hasLiked = session()->get($sessionKey, false);

        if ($hasLiked) {
            // Unlike logic
            $review->decrement('likes_count');
            session()->forget($sessionKey);
            return response()->json([
                'success' => true,
                'liked' => false,
                'likes_count' => max(0, $review->fresh()->likes_count),
                'message' => 'ยกเลิกการถูกใจแล้ว'
            ]);
        } else {
            // Like logic
            $review->increment('likes_count');
            session()->put($sessionKey, true);
            return response()->json([
                'success' => true,
                'liked' => true,
                'likes_count' => $review->fresh()->likes_count,
                'message' => 'ถูกใจรีวิวเรียบร้อยแล้ว'
            ]);
        }
    }
}
