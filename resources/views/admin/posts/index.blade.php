@extends('layouts.app')

@section('title', 'Admin Posts')

@section('content')
<table class="table table-hover align-middle bg-white border text-secondary mb-5">
    <thead class="table-primary small text-secondary">
        <tr>
            <th></th>
            <th></th>
            <th>CATEGORY</th>
            <th>OWNER</th>
            <th>CREATED AT</th>
            <th>STATUS</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($all_posts as $post)
            <tr>
                <td class="text-end">{{$post->id}}</td>
                <td>
                    <a href="{{route('post.show', $post->id)}}">
                        <img src="{{$post->image}}" alt="post id {{$post->id}}" class="d-block mx-auto image-lg" >
                    </a>
                </td>
                <td>
                    @foreach ($post->categoryPost as $category_post)
                        <span class="badge bg-secondary bg-opacity-50">
                            {{$category_post->category->name}}
                        </span>
                    @endforeach
                </td>
                <td>
                    <a href="{{route('profile.show', $post->user->id)}}" class="text-dark text-decoration-none">
                        {{$post->user->name}}
                    </a>
                </td>
                <td>
                    {{$post->created_at}}
                </td>
                <td>
                    @if ($post->trashed())
                    <i class="fa-solid fa-circle-minus text-secondary"></i>&nbsp; Hidden
                    @else
                        <i class="fa-solid fa-circle text-primary"></i>&nbsp; Visible 
                    @endif
                    
                </td>
                <td>
                        @if ($post->trashed())
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item text-secandary" data-bs-toggle="modal" data-bs-target="#unhide-post-{{$post->id}}">
                                        <i class="fa-solid fa-eye"></i>&nbsp;Unhide Post {{$post->id}}
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="dropdown">
                                <button class="btn btn-sm" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                                        <i class="fa-solid fa-eye-slash"></i>&nbsp;Hide Post {{$post->id}}
                                    </button>
                                </div>
                            </div>
                        @endif
                        
                        {{-- include the modal here --}}
                        @include('admin.posts.modal.status')
                    
                </td>
            </tr>
        @empty
                <tr>
                    <td colspan="7" class="lead text-muted text-center">No posts found.</td>
                </tr>
        @endforelse
    </tbody>
</table>
{{$all_posts->links()}}
    {{-- {{$all_posts->links()}} --}}
    {{-- <h2>Your hiding posts</h2>
    <table class="table table-hover align-middle bg-white border text-secondary">
        <thead class="table-sucess small text-secondary">
            <tr>
                <th></th>
                <th></th>
                <th>CATEGORY</th>
                <th>OWNER</th>
                <th>CREATED AT</th>
                <th>DELETED AT</th>
                <th>STATUS</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($all_deleted as $post)
                <tr>
                    <td class="text-end">{{$post->id}}</td>
                    <td>
                        <a href="{{route('post.show', $post->id)}}">
                            <img src="{{$post->image}}" alt="post id {{$post->id}}" class="d-block mx-auto image-lg" style="height: 50px; width:50px;">
                        </a>
                    </td>
                    <td>
                        @foreach ($post->categoryPost as $category_post)
                            <span class="badge bg-secondary bg-opacity-50">
                                {{$category_post->category->name}}
                            </span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{route('profile.show', $post->user->id)}}" class="text-darl text-decoration-none">
                            {{$post->user->name}}
                        </a>
                    </td>
                    <td>
                        {{$post->created_at}}
                    </td>
                    <td>
                        {{$post->deleted_at}}
                    </td>
                    <td>
                        <i class="fa-solid fa-circle text-danger"></i>&nbsp; Invisible
                    </td>
                    {{-- <td>
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                                    <i class="fa-solid fa-eye-slash"></i>Hide Post{{$post->id}}
                                </button>
                            </div>
                        </div>
                        {{-- include the modal here
                        @include('admin.posts.modal.status')
                    </td> 
                </tr>
                <tr>
                    @if ($post->user->id === Auth::user()->id)
                        <div class="dropdown">
                            <button class="btn btn-sm" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#hide-post-{{$post->id}}">
                                    <i class="fa-solid fa-eye-slash"></i>Hide Post{{$post->id}}
                                </button>
                            </div>
                        </div>
                        {{-- include the modal here 
                        @include('admin.posts.modal.status')
                    @endif
                    
                </tr>
                @empty
                    <tr>
                        <td colspan="7" class="lead text-muted text-center">No posts found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table> --}}
        {{-- {{$all_posts->links()}} --}}
@endsection
        