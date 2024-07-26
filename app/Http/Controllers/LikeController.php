<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $likes = Like::all();
        return response()->json($likes, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $like = new Like();
        $like->like_type = 'like';
        $like->user_id = $request->input('user_id');  // 使用 $request->input
        $like->idea_id = $request->input('idea_id');  // 使用 $request->input
        $like->save();
        return response()->json($like, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $idea_id = $request->input('idea_id');
        $user_id = $request->input('user_id');
        $idea = Idea::withCount([
            'likes as like_count' => function ($query) {
                $query->where('like_type', 'like');
            },
            'likes as dislike_count' => function ($query) {
                $query->where('like_type', 'dislike');
            }
        ])->findOrFail($idea_id);

        // get all likes
        $likes = Like::where('idea_id', $idea_id)->get();

        // check if liked
        $liked = $likes->where('user_id', $user_id)->isNotEmpty();


        return response()->json([
            'idea_id' => $idea->id,
            'liked' => $liked,
            'like_count' => $idea->like_count,
            'dislike_count' => $idea->dislike_count
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $idea_id = $request->input('idea_id');
        $user_id = $request->input('user_id');
        $like = Like::where('idea_id', $idea_id)
            ->where('user_id', $user_id)
            ->first();
        if (!$like) {
            return response()->json(['message' => 'Record not found'], 404);
        }
        $like->delete();
        return response()->json($like, 200);
    }
}
