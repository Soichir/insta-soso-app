<div class="row">
    <div class="col-4">
        @if($user->avatar)
            <img src="{{$user->avatar}}" class="img-thumbnail rounded-circle d-block mx-auto avatar-lg" style="width:9rem; height:9rem; object-fit:cover; ">
        @else
        <i class="fa-solid fa-circle-user text-secondary d-block text-center icon-lg"></i>
        @endif
    </div>

    <div class="col-8">
        <div class="row mb-3">
            <div class="col-auto">
                <h2 class="display-6 mb-0">{{ $user->name }}</h2>
            </div>

            <div class="col-auto p-2">
                @if(Auth::user()->id === $user->id)
                    <a href="{{route('profile.edit')}}" class="btn btn-outline-secondary btn-sm fw-bold">Edit Profile</a>
                   
                    <div class="dropdown mt-3" >
                        <a href="#" class="btn btn-primary dropdown-toggle" id="profileMenu" role="button" aria-expanded="false" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-gear"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="profileMenu">
                            <li><a href="{{route('profile.blocklist', $user->id)}}" class="dropdown-item"><i class="fa-solid fa-user-xmark"></i>Block Lists</a></li>
                        </ul>
                    </div>
                @else
                    @unless ($user->isBlocking() || $user->isBlocked())
                        @if ($user->isFollowed())  
                            <form action="{{route('follow.destroy', $user->id)}}" method="post" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary btn-sm fw-bold">Unfollow</button>
                            </form>                                   
                        @else
                            <form action="{{route('follow.store', $user->id)}}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm fw-bold">Follow</button>
                            </form>
                        @endif
                    @endunless
                    
                    
                @endif
            </div>
            <div class="col-auto p-2">
                @if(Auth::user()->id !== $user->id)
                    @if ($user->isBlocked() === true)
                        <form action="{{route('block.destroy', $user->id)}}" method="post" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary btn-sm">Unblock</button>
                        </form>
                    @elseif($user->isBlocked() === false && $user->isFollowed())
                        <button type="submit" data-bs-toggle="modal" data-bs-target="#blockFollow-{{$user->id}}" class="btn btn-danger btn-sm fw-bold">
                            Block
                        </button>
                    @else
                        <button type="submit" data-bs-toggle="modal" data-bs-target="#block-{{$user->id}}" class="btn btn-danger btn-sm fw-bold">
                            Block
                        </button>
                    @endif

                @endif
            </div>
        </div>
        @include('users.profile.modal.block')
        @if ($user->isBlocked())
            <h2>This user is blocked.</h2>
        @else
            <div class="row mb-3">
                <div class="col-auto">
                    <a href="{{route('profile.show', $user->id)}}" class="text-decoration-none text-dark">
                        <strong>{{ $user->posts->count() }}</strong> {{$user->posts->count() ==1 ? 'post':'posts'}}
                    </a>
                </div>

                <div class="col-auto">
                    <a href="{{route('profile.followers', $user->id)}}" class="text-decoration-none text-dark">
                        <strong>{{$user->followers->count()}}</strong> {{$user->followers->count() ==1 ? 'Follower':'Followers'}}
                    </a>
                </div>

                <div class="col-auto">
                    <a href="{{route('profile.following', $user->id)}}" class="text-decoration-none text-dark">
                        <strong>{{$user->following->count()}}</strong> following
                    </a>
                </div>
                
            </div>
            <p class="fw-bold">{{ $user->introduction }}</p>
        @endif
        
        
    </div>
</div>