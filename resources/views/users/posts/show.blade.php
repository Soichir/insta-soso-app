@extends('layouts.app')

@section('title', 'Show Post')

@section('content')
<style>
    .col-4{
        overflow-y: scroll;
    }
    
    .card-body{
        position: absolute;
        top: 65px;
    }
</style>


    {{-- @unless($post->user->isBlocked() || $post->user->isBlocking()) --}}
    <div class="row border shadow">
        <div class="col p-0 border-end">
            <img src="{{$post->image}}" alt="post id {{$post->id}}" class="w-100">
        </div>
        <div class="col-4 px-0 bg-white">
            <div class="card border-0">
                <div class="card-header py-3 bg-white">
                        <div class="row align-items-center">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <a href="{{route('profile.show', $post->user->id)}}">
                                        @if($post->user->avatar)
                                            <img src="{{$post->user->avatar}}" alt="{{$post->user->name}}" class="rounded-circle avatar-sm">
                                        @else
                                            <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
                                        @endif
                                    </a>
                                </div>
                                <div class="col ps-0">
                                    <a href="{{route('profile.show', $post->user->id)}}" class="text-decoration-none text-secondary">{{$post->user->name}}</a>
                                </div>
                                <div class="col-auto">
                                    {{-- If you are the OWNER of the post, you can edit or delete the post --}}
                                    @if (Auth::user()->id === $post->user->id)
                                        <div class="dropdown">
                                            <button class="btn btn-sm shadow-none" data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis"></i>
                                            </button>
                                            {{-- If you are the OWNER of the post, you can edit or delete the post --}}
                                            <div class="dropdown-menu">
                                                    <a href="{{route('post.edit', $post->id)}}" class="dropdown-item text-warning">
                                                        <i class="fa-regular fa-pen-to-square"></i> Edit
                                                    </a>
                                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                                                    <i class="fa-regular fa-trash-can"></i> Delete
                                                    </button>
                                            </div>
                                                {{-- Insert a modal --}}
                                                @include('users.posts.contents.modals.delete')

                                        </div>
                                    @else
                                            {{-- If you are NOT the OWNER of the post, then show a Follow/Unfollow button. To be discussed later --}}
                                            {{-- Display a follow button for now --}}
                                            {{-- <div class="dropdown-menu"> --}}
                                                @if ($post->user->isFollowed())  
                                                    <form action="{{route('follow.destroy', $post->user->id)}}" method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-secondary btn-sm fw-bold">Unfollow</button>
                                                    </form>                                   
                                                @else
                                                    <form action="{{route('follow.store', $post->user->id)}}" method="post" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                                                    </form>
                                                @endif
                                    @endif
                            </div>
                        
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <form action="{{route('like.store', $post->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm shadow-none p-0"><i class="fa-regular fa-heart"></i></button>
                        </form>
                    </div>
                    <div class="col-auto px-0">
                        <span>{{$post->likes->count()}}</span>
                    </div>
                    <div class="col text-end">
                        @foreach($post->categoryPost as $category_post)
                            <div class="badge bg-secondary bg-opacity-50">
                                {{$category_post->category->name}}
                            </div>
                        @endforeach
                    </div>
                </div>
                <form action="{{ route('comment.store', $post->id) }}" method="post">
                    @csrf               
                    <div class="input-group">
                        <textarea name="comment_body{{$post->id}}" rows="1" class="form-control sm" placeholder="Add a comment...">{{old('comment_body' . $post->id)}}</textarea>
                        <button type="submit" class="btn btn-outline-secondary btn-sm">Post</button>
                    </div>
                    {{-- Error --}}
                    @error('comment.body' . $post->id)
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </form>
           

            {{-- Show all comments here --}}
            @if($post->comments->isNotEmpty())
                <ul class="list-group mt-2">
                    @foreach($post->comments as $comment)
                        <li class="list-group-item border-0 p-0 mb-2">
                            <a href="{{route('profile.show', $comment->user->id)}}" class="text-decoration-none text-dark fw-bold">{{ $comment->user->name}}</a>
                            &nbsp;
                            <p class="d-inline fw-light">{{ $comment->body }}</p>
                        

                            <form action=" {{route('comment.destroy', $comment->id)}} " method="post">
                                @csrf
                                @method('DELETE')

                                <span class="text-uppercase text-muted xsmall">
                                    {{ date('M d Y', strtotime($comment->created_at)) }}
                                </span>

                                @if(Auth::user()->id === $comment->user->id)
                                    &middot;
                                    <button type="submit" class="border-0 bg-transparant text-danger p-0 xsmall">Delete</button>
                                @endif

                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
            </div>
        </div>
    </div>
    {{-- @endunless --}}
    

@endsection