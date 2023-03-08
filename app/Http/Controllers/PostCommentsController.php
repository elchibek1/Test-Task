<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostCommentsController extends Controller
{
    public function store(CommentRequest $request)
    {
        $data = $request->validated();
        if($request->hasFile('picture'))
        {
            $data['picture'] = $request->file('picture')->store('pictures/posts', 'public');
        }
        Comment::create(array_merge($data, ['user_id' => Auth::id(), 'post_id' => $request['post_id']]));
        return back()->with('message', 'Comment successfully created');
    }

    public function destroy(Post $post, Comment $comment)
    {
        //$this->authorize('delete', $comment);
        $comment->delete();
        return back()->with('message', 'Comment deleted');
    }
}
