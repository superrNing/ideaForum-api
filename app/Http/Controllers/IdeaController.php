<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchKey = $request->query('search_key', '');
        // ideas with like and dislike and comment count
        $query = Idea::withCount(['likes as like_count' => function ($query) {
            $query->where('like_type', 'like');
        }, 'likes as dislike_count' => function ($query) {
            $query->where('like_type', 'dislike');
        }, 'comments'])->orderBy('created_at', 'desc');
        // $ideas = Idea::withCount(['likes', 'comments'])->get();

        // search if has search term
        if (!empty($searchKey)) {
            $query->where(function ($q) use ($searchKey) {
                $q->where('title', 'like', '%' . $searchKey . '%')
                    ->orWhere('description', 'like', '%' . $searchKey . '%');
            });
        }
        $ideas = $query->get();
        return response()->json($ideas, 200);
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
    public function store()
    {
        $idea = new Idea();
        $idea->title = request('title');
        $idea->description = request('description');
        $idea->user_id = request('user_id');

        // logger()->info("Received user_id: $userId, idea_id: $ideaId");

        $idea->save();
        return response()->json($idea, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $idea_id = $request->query('idea_id');
        $idea = Idea::with('user')->find($idea_id);

        return response()->json($idea, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        $idea_id = request('idea_id');
        $idea = Idea::find($idea_id);
        $idea->title = request('title');
        $idea->description = request('description');
        $idea->user_id = request('user_id');
        $idea->save();
        return response()->json($idea, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $idea_id = $request->query('idea_id');
        $idea = Idea::findOrFail($idea_id);

        // check if it's author
        if (Auth::id() !== $idea->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $idea->delete();

        return response()->json(['message' => 'Idea deleted successfully'], 200);
    }
}
