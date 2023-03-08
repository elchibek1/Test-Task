@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="post" style="display: flex">
            <img src="{{asset('storage/' . $post->picture)}}"
                 style="max-width: 700px; max-height: 500px">
            <div class="description px-5 pb-3 mt-3">
                <h3 class="title">{{$post->title}}</h3>
                <h5 class="body">{{$post->text}}</h5>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row row-cols-md-3">
            <div class="col-md-12">
                <h3 class="text-center">
                    Комментарии
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Добавить комментарий
                    </button>
                </h3>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Create new comment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="comment-form">
                            <form action="{{route('posts.comments.store', ['post' => $post])}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="post_id" name="post_id" value="{{$post->id}}">
                                <div class="form-group">
                                    <label for="commentFormControl">Комментарий</label>
                                    <textarea name="text" class="form-control" id="commentFormControl" rows="3"
                                              required>{{old('text')}}</textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <div class="custom-file">
                                        <label class="custom-file-label form-control"
                                               for="customFile">Фотография</label>
                                        <input type="file" class="custom-file-input" multiple id="customFile"
                                               name="picture">
                                        @error('picture')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <button class="btn btn-primary pt-2">Сохранить</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-create-comment-modal"
                                data-bs-dismiss="modal">
                            Закрыть
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row-cols-sm-1 row-cols-md-3">
            <div class="col-1 mt-3 pt-3">
                @foreach($post->comments as $comment)
                    <div class="media g-mb-30 media-comment" style="display: flex">
                        <img src="{{asset('storage/' . $comment->picture)}}"
                             style="max-width: 150px; max-height: 150px">
                        <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30 px-3">
                            <div class="g-mb-15">
                                <h5 class="h5 g-color-gray-dark-v1 mb-0">{{$comment->user->name}}</h5>
                                <span
                                    class="g-color-gray-dark-v4 g-font-size-12">{{$comment->created_at->diffForHumans()}}</span>
                                <h5>
                                    {{$comment->text}}
                                </h5>
                            </div>

                            <button class="btn btn-outline-success pb-1" data-bs-toggle="modal"
                                    data-bs-target="#exampleModalEdit">
                                Изменить комментарий
                            </button>
                            <div class="modal fade" id="exampleModalEdit" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalScrollableTitle">Create new
                                                comment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="comment-form">
                                                <form action="{{route('posts.comments.store', ['post' => $post])}}"
                                                      method="post"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" id="post_id" name="post_id"
                                                           value="{{$post->id}}">
                                                    <div class="form-group">
                                                        <label for="commentFormControl">Комментарий</label>
                                                        <textarea name="text" class="form-control"
                                                                  id="commentFormControl" rows="3"
                                                                  required>{{$comment->text}}</textarea>
                                                        @error('text')
                                                        <div class="alert alert-danger">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group mt-3">
                                                        <div class="custom-file">
                                                            <label class="custom-file-label form-control"
                                                                   for="customFile">Фотография</label>
                                                            <input type="file" class="custom-file-input" multiple
                                                                   id="customFile"
                                                                   name="picture">
                                                            @error('picture')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary pt-2">Сохранить</button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary close-create-comment-modal"
                                                    data-bs-dismiss="modal">
                                                Закрыть
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form action="{{route('posts.comments.destroy', ['post' => $post, 'comment' => $comment])}}"
                                  method="post">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-outline-danger delete-comment">Удалить</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{--        <div class="row pt-1">--}}
    {{--            <div class="col">--}}
    {{--                {{$post->comments->links()}}--}}
    {{--            </div>--}}
    {{--        </div>--}}
@endsection