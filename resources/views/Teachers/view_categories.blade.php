@extends('layout')
@section('hero')
    <div class="container">
        <table class="table table-responsive" style="--bs-table-bg: transparent;">
            <tr>
                <th>Category Name</th>
                <th>Action</th>
            </tr>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->category_name }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#editcategory">Edit</button>

                            <div class="modal fade" id="editcategory" tabindex="-1" aria-labelledby="editcategoryLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('edit_category_submit') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="category_id"
                                                    value="{{ $category->category_id }}">
                                                <input type="text" name="category_name"
                                                    value="{{ $category->category_name }}">
                                                <input type="submit" class="btn btn-primary">
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('delete_category') }}" method="post">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                <input type="submit" value="Delete" class="btn btn-danger">
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                Empty Category
            @endforelse
        </table>
    </div>
@endsection
