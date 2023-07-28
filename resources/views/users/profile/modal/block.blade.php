<div class="modal fade" id="block-{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border danger">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="fa-solid fa-user-xmark"></i> Block User
                </h5>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to block {{$user->name}} ?</p>
            </div>

            <div class="modal-footer border-0">

                <form action="{{route('block.store', $user->id)}}" method="post">
                    @csrf

                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Block</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="blockFollow-{{ $user->id }}">
    <div class="modal-dialog">
        <div class="modal-content border danger">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="fa-solid fa-user-xmark"></i> Block User
                </h5>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to block {{$user->name}} ?</p>
                <p>You will automatically unfollow {{$user->name}} .</p>
            </div>

            <div class="modal-footer border-0">

                <form action="{{route('block.blockFollow', $user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Block</button>
                </form>
            </div>
        </div>
    </div>
</div>