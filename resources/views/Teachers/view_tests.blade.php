@extends('layout')

@section('hero')
    <div class="container mt-3">
        <h3><u>Tests</u></h3>

        @forelse ($tests as $test)
            <div class="card mt-2">
                <h5 class="card-header">
                    Test Name : {{ $test->title }}
                </h5>

                <div class="card-body">
                    <div class="row align-items-center">

                        <div class="col">
                            <h5 class="card-title">Candidate Name : {{ $test->user->name }}</h5>

                            <div class="fw-bold">
                                Questions :
                                @php $question_ids = explode(',', $test->question_ids); @endphp

                                @foreach ($question_ids as $question_id)
                                    @php $question = App\Models\Question::find($question_id); @endphp

                                    <code>
                                        {{ $question->title ?? 'NA' }},
                                    </code>
                                @endforeach
                            </div>

                            <p>Start Date & Time : {{ $test->startdatetime }}</p>
                        </div>
                        @php
                            $testendtime = Illuminate\Support\Carbon::make($test->startdatetime)->clone()->addHour(3);
                        @endphp
                        <div class="col-auto">
                            @if ($test->status == 'pending' && $testendtime->isPast())
                                <span class="badge bg-danger">Status : Not attempted</span>
                            @elseif ($test->status == 'pending')
                                <span class="badge bg-warning text-dark">Status : pending</span>
                            @elseif ($test->status == 'completed')
                                <span class="badge bg-success">Status : completed</span>
                            @elseif ($test->status == 'Not attempted')
                                <span class="badge bg-danger">Status : Not attempted</span>
                            @endif


                        </div>

                        <div class="col-auto">
                            <form action="{{ route('remove_tests') }}" method="post" class="d-flex gap-2">
                                @csrf
                                <input type="hidden" name="test_id" value="{{ $test->id }}">

                                <button onclick="null_questions()" type="button" class="btn btn-outline-primary"
                                    data-bs-toggle="modal" data-bs-target="#edit_tests{{ $test->id }}">
                                    Edit
                                </button>

                                <button type="submit" class="btn btn-outline-danger">Remove</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Modal --}}
            <div class="modal fade" id="edit_tests{{ $test->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">Edit Test</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <form method="post" action="{{ route('edit_assign_test') }}">
                            <input type="hidden" name="test_id" value="{{ $test->id }}">
                            @csrf

                            <div class="modal-body">
                                <div class="row g-3">

                                    <div class="col-md-4">
                                        <label class="form-label">Enter Title</label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ $test->title }}" required>

                                        <label class="form-label mt-2">Choose Question category</label>
                                        <select name="category" class="form-control" onchange="view_questions(this.value)">
                                            <option value="">--Please Select--</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="questions"></div>
                                    </div>

                                    <div class="col-md-8">
                                        <label class="form-label">Select Student</label>
                                        <select name="student" class="form-select">
                                            <option value="">Choose...</option>
                                            @foreach ($students as $student)
                                                @if ($student->id == $test->user_id)
                                                    <option value="{{ $student->id }}" selected>{{ $student->name }}
                                                    </option>
                                                @else
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        <label class="form-label mt-2">Start Date & Time</label>
                                        <input type="datetime-local" name="startdatetime" class="form-control"
                                            value="{{ $test->startdatetime }}">
                                    </div>

                                </div>
                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary">Save Changes</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        @empty
        @endforelse


    @endsection
