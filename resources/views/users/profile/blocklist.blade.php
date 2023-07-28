@extends('layouts.app')

@section('title', 'Blocklist')

@section('content')
    @include('users.profile.header')

    <div style="margin-top:100px;">
        @if ($user->blocking->isNotEmpty())
            <div class="row justify-content-center">
                <div class="col-4">
                    <h3 class="text-muted text-center">Blocked users</h3>

                    @foreach ($user->blocking as $blocking)
                        <div class="list-group">
                            <div class="list-group-item">
                                <div class="row">
                                    <div class="col-6 my-auto">
                                        {{$blocking->blocking->name}}
                                    </div>
                                    <div class="col-auto">
                                        <form action="{{route('block.destroy', $blocking->blocking->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn border-0 bg-transparent text-secondary">Unblock</button>
                                        </form>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <h3 class="text-muted text-center">You are blocking nobody.</h3>
        @endif
    </div>

{{-- <h1>block</h1>
    @if ($user->blocking->isNotEmpty())
        <div class="ul">
            @foreach ($user->blocking as $blocking)
                <li class="list-group-item">{{$blocking->blocking->name}}</li>
            @endforeach
        </div>
    @endif --}}
    
@endsection

