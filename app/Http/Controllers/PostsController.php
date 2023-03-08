<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $posts = Post::paginate(8);
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): Application|Factory|View
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse
     */
    public function store(PostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        if($request->hasFile('picture'))
        {
            $data['picture'] = $request->file('picture')->store('pictures/posts', 'public');
        }
        Post::create(array_merge($data, ['user_id' => Auth::id()]));
        return redirect()->route('posts.index')->with('message', "Post successfully created");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return Application|Factory|View
     */
    public function show(Post $post): View|Factory|Application
    {

        $comments = Comment::where('post_id', $post->id)->get();
        $post->setRelation('comments', $post->comments()->paginate(6));
        return view('posts.show', compact('post','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return Application|Factory|View
     */
    public function edit(Post $post): View|Factory|Application
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return RedirectResponse
     */
    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update-post', $post);
        $data = $request->validated();
        if($request->hasFile('picture'))
        {
            $file = $request->file('picture');
            $path = $file->store('pictures/posts', 'public');
            $data['picture'] = $path;
        }
        $post->update($data);
        return redirect()->route('posts.index')->with('message', "Post successfully updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete-post', $post);
        $post->delete();
        return redirect()->route('posts.index')->with('message', "Post successfully deleted");
    }
}
