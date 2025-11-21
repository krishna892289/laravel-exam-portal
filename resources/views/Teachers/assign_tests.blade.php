@extends('layout')
@section('hero')
    <div class="container mt-3">
        <div class="row">
            <div class="col-md-4">
                <form method="post" action="{{ route('assign_test') }}">
                    @csrf
                    <label for="titleinput" class="form-label">Enter Title</label>
                    <input type="text" id="titleinput" name="title" class="form-control" placeholder="Enter Test Title">
                    <label for="inputquestions" class="form-label">Select Questions</label>
                    @forelse ($questions as $question)
                        <div class="form-check">
                            <input class="form-check-input" name="questions[]" type="checkbox"
                                id="inputquestions{{ $question->id }}" value="{{ $question->id }}">
                            <label class="form-check-label" for="gridCheck">
                                {{ $question->title }}
                                <span class="text-secondary">({{ $question->category->category_name }})</span>
                            </label>

                        </div>
                    @empty
                        No questions found
                    @endforelse
            </div>
            <div class="col-md-8">
                <label for="inputstudents" class="form-label">Select Student</label>
                <select id="inputstudents" name="student" class="form-select">
                    <option selected>Choose...</option>
                    @forelse ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @empty
                    @endforelse
                </select>
                <label for="startdate" class="form-label">Start Date & Time</label>
                <input type="datetime-local" name="startdatetime" class="form-control" id="startdatetime">
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
