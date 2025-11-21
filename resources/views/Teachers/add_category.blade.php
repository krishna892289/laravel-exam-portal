@extends('layout')
@section('hero')
    <div class="container">
        <form action="{{ route('add_category_submit') }}" method="post">
            @csrf
            <input type="text" name="category_name" placeholder="Add Category Name">
            <input type="submit" value="Submit">
        </form>
    </div>
@endsection
