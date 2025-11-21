@extends('layout')
@section('hero')
    <div class="container">
        <h3><u>Tests</u></h3>
        @forelse ($tests as $test)
            <div class="col"><b>Test Name</b> : {{ $test->title }}</div>
            <div class="row">
                <div class="col">
                    <h4>Name : {{ $test->user->name }}</h4>
                    <b> Questions :
                        @php
                            $question_ids = explode(',', $test->question_ids);
                        @endphp
                        @foreach ($question_ids as $question_id)
                            @php
                                $question = App\Models\Question::where('id', $question_id)->first();
                            @endphp
                            <code>
                                @if (!isset($question->title))
                                    'NA'
                                @else
                                    {{ $question->title }}
                                @endif
                            </code>
                        @endforeach
                    </b>
                    <p>Start Date & Time {{ $test->startdatetime }}</p>

                </div>
                <div class="col">
                    @if ($test->status == 'pending')
                        <h4 class="bg-warning text-light">Status : {{ $test->status }}</h4>
                    @elseif ($test->status == 'completed')
                        <h4 class="bg-info text-success">Status : {{ $test->status }}</h4>
                    @elseif ($test->status == 'Not attempted')
                        <h4 class="bg-danger text-light">Status : {{ $test->status }}</h4>
                    @endif
                </div>
                <div class="col">
                    <form action="{{ route('remove_tests') }}" method="post">
                        @csrf
                        <input type="hidden" name="test_id" value="{{ $test->id }}">
                        <button type="submit" class="btn btn-outline-danger">Remove</button>
                    </form>
                </div>
            </div>
        @empty
        @endforelse
    </div>
@endsection
