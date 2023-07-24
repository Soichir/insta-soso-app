@extends('layouts.app')

@section('title', 'Admin Categories')

@section('content')


<form action="{{route('admin.create')}}" method="post">
    @csrf
    <div class="input-group mb-3">
        <input type="text" name="name" id="" placeholder="Add a category..." class=" rounded w-50">
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Add</button>
    </div>
    
</form>
<table class="table table-hover align-middle bg-white border text-secondary w-75">
    <thead class="table-warning small">
        <th>#</th>
        <th>NAME</th>
        <th>COUNT</th>
        <th>LAST UPDATED</th>
        <th></th>
    </thead>
    <tbody>
        @foreach($all_categories as $category)
            <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td></td>
                <td>{{$category->updated_at}}</td>
                <td>
                    <button type="button" class="btn btn-outline-warning small"><i class="fa-solid fa-pen"></i></button>
                    <button type="button" class="btn btn-outline-danger small" data-bs-toggle="modal" data-bs-target="#delete-category-{{$category->id}}"><i class="fa-solid fa-trash-can"></i></button>
                    @include('admin.categories.modal.delete')
                </td>
            </tr>
           
        @endforeach
        
    </tbody>
</table>

@endsection