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
            $data['picture'] = $request->file('picture')->store('pictures/comments', 'public');
        }
        Comment::create(array_merge($data, ['user_id' => Auth::id(), 'post_id' => $request['post_id']]));
        return back()->with('message', 'Comment successfully created');
    }

    public function update(Comment $comment, CommentRequest $request)
    {
        $this->authorize('update-comment',  $comment);
        $data = $request->validated();
        if($request->hasFile('picture'))
        {
            $file = $request->file('picture');
            $path = $file->store('pictures/comments', 'public');
            $data['picture'] = $path;
        }
        $comment->update($data);
        return back()->with('message', "Comment successfully updated");
    }

    public function destroy(Post $post, Comment $comment)
    {
        $this->authorize('delete-comment', $comment);
        $comment->delete();
        return back()->with('message', 'Comment deleted');
    }
}
