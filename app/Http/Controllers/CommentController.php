<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $comment = new Comment();
        $comment->comment_text = request('comment_text');
        $comment->user_id = request('user_id');
        $comment->idea_id = request('idea_id');
        $comment->save();
        return response()->json($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $idea_id = $request->query('idea_id');
        $idea = Idea::with(['comments.user'])->findOrFail($idea_id);
        // $comments = $idea->comments;
        $comments = $idea->comments()->with('user')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'idea_id' => $idea_id,
            'comments' => $comments
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $comment_id = $request->query('comment_id');
        $comment = Comment::findOrFail($comment_id);

        // check if it's author
        if (Auth::id() !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
