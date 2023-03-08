@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="header text-center" style="display: flex">
            <h3 class="px-5 mx-5">Посты</h3>
            <div class="">
                <a href="{{route('posts.create')}}">
                    <button type="submit" class="btn btn-outline-primary">
                        Создать пост
                    </button>
                </a>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-2 pt-5 text-center">
            @foreach($posts as $post)
                <div class="col">
                    <div class="card">
                        <h4 class="card-title">{{$post->title}}</h4>
                        <a href="{{route('posts.show', ['post' => $post])}}">
                            <img src="{{asset('storage/' . $post->picture)}}"
                                 style="width: 300px; height: 300px">
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="justify-content-md-center p-5">

            <div class="col-md-auto">

                {{ $posts->links() }}

            </div>

        </div>
    </div>
@endsection
