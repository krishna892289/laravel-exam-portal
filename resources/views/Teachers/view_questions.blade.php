@extends('layout')
@section('hero')
    <div class="container mt-3 ">
        <table class="table table-responsive" style="--bs-table-bg: transparent;">
            <tr>
                <th>Category</th>
                <th>Title</th>
                <th>Description</th>
                <th>Image</th>
                <th>Answer</th>
                <th>action</th>
            </tr>
            @forelse ($questions as $question)
                <tr>
                    @php
                        $category = App\Models\Category::where('id', $question->category_id)->first();
                    @endphp
                    <td>{{ $category->category_name }}</td>
                    <td>{{ $question->title }}</td>
                    <td>{{ $question->description }}</td>
                    <td><img src="{{ asset('questions12/images') . '/' . $question->image }}"
                            style="width: 100px;height:100px">
                    </td>
                    <td>
                        @foreach ($question->answers as $answers)
                            @if ($answers->correct == '1')
                                <p>{{ $answers->answer }}</p>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <form action="{{ route('delete_question') }}" method="post">
                            @csrf
                            <input type="hidden" name="question_id" value="{{ $question->id }}">
                            <button type="submit" class="btn btn-danger">Delete Question</button>
                        </form>
                    </td>
                </tr>
            @empty
            @endforelse
        </table>
    </div>
@endsection
