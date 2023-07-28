@extends('layouts.app')

@section('title')

@section('content')

    @include('users.profile.header')

    {{-- Show all posts here --}}
    @unless($user->isBlocked())
        @if ($user->isBlocking())
            <h2 class="text-muted text-center">You are blocked by {{$user->name}}</h2>
        @else
            <div style="margin-top: 100px">
                @if($user->posts->isNotEmpty())
                    <div class="row">
                        @foreach($user->posts as $post)
                            <div class="col-lg-4 col-md mb-4">
                                <a href="{{ route('post.show', $post->id) }}">
                                    <img src="{{ $post->image }}" alt="post id {{ $post->id }}" class="grid-img">
                                </a>
                            </div>
                        @endforeach
                    </div>

                @else
                    <h3 class="text-muted text-center">No posts yet.</h3>
                @endif
            </div>
        @endif
        
    @endunless

@endsection