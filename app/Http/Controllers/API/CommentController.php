<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CommentController extends Controller
{

    public function store(Request $request)
    {
        $data = $request->validate([
            'commentable_type' => 'required|in:track,album',
            'commentable_id'   => 'required|integer',
            'author'           => 'nullable|string|max:255',
            'body'             => 'required|string',
        ]);

        $model = match ($data['commentable_type']) {
            'track' => \App\Models\Track::findOrFail($data['commentable_id']),
            'album' => \App\Models\Album::findOrFail($data['commentable_id']),
        };

        $comment = $model->comments()->create([
            'author' => $data['author'] ?? null,
            'body'   => $data['body'],
        ]);

        return (new CommentResource($comment))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Comment deleted']);
    }
}