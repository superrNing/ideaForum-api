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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $idea_id = $request->query('idea_id');
        $idea = Idea::withCount([
            'likes as like_count' => function ($query) {
                $query->where('like_type', 'like');
            },
            'likes as dislike_count' => function ($query) {
                $query->where('like_type', 'dislike');
            }
        ])->findOrFail($idea_id);

        return response()->json([
            'idea_id' => $idea->id,
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
    public function destroy(Like $like)
    {
        //
    }
}
