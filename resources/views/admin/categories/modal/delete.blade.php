<div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border danger">
            <div class="modal-header border-danger">
                <h5 class="modal-title text-danger">
                    <i class="fa-solid fa-trash-can"></i> Delete Category
                </h5>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete {{$category->name}} category?</p>
                <div class="mt-3">                  
                    <p class="mt-1 text-muted">
                        This action will affect all the posts under this category. Posts without a category will fall under Uncategorized.
                    </p>
                </div>
            </div>

            <div class="modal-footer border-0">
                <form action="{{route('admin.categories.destroy', $category->id)}}" method="post">
                    @csrf
                    @method('DELETE')

                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">delete</button>
                </form>
            </div>
        </div>
    </div>
</div>